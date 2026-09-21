<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Olt_data;
use Illuminate\Support\Facades\Http;

class SyncOnuData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;
    public $tries = 3;

    public function handle(): void
    {
        DB::table('olt_devices')
            ->orderBy('id')
            ->chunk(10, function ($devices) {

                foreach ($devices as $device) {

                    try {

                        /*------ lock system------*/
                        $lockKey = 'olt_sync_' . $device->id;

                        $lock = cache()->lock($lockKey, 240);

                        if (!$lock->get()) {
                            continue;
                        }

                        try {

                            $url = "http://103.191.50.88/olt_data/?brand=".$device->brand.
                                "&ip=".$device->ip_address.
                                "&ip_port=".$device->port.
                                "&port=65535&lang=0";

                            $response = Http::timeout(25)
                                ->retry(3, 2000)
                                ->get($url);

                            if (!$response->successful()) {
                                continue;
                            }

                            $data = $response->json();

                            $onus = $data['onu'] ?? [];
                            $macs = $data['mac'] ?? [];

                            /*-------- Onu Process ---------*/

                            $_onu_insert_data = [];

                            foreach ($onus as $onu) {

                                if (empty($onu['mac'])) {
                                    continue;
                                }

                                $_onu_insert_data[] = [
                                    'olt_id'        => $device->id,
                                    'pon_port'      => $onu['onu'] ?? null,
                                    'mac_address'   => $onu['mac'],
                                    'rx_power'      => $onu['rx_power'] ?? null,
                                    'tx_power'      => $onu['tx_power'] ?? null,
                                    'status'        => $onu['status'] ?? null,
                                    'offline_time'  => $onu['offline_time'] ?? null,
                                    'reason'        => $onu['reason'] ?? null,
                                    'updated_at'    => now(),
                                    'created_at'    => now(),
                                ];
                            }

                            /*---------batch upsert---------*/
                            if (!empty($_onu_insert_data)) {

                                DB::table('olt_data')->upsert(
                                    $_onu_insert_data,
                                    ['mac_address', 'olt_id'],
                                    [
                                        'pon_port',
                                        'rx_power',
                                        'tx_power',
                                        'status',
                                        'offline_time',
                                        'reason',
                                        'updated_at'
                                    ]
                                );
                            }

                            /*----------Mac Process---------*/

                            $_mac_insert_data = [];

                            foreach ($macs as $mac) {

                                if (empty($mac['mac'])) {
                                    continue;
                                }

                                $_mac_insert_data[] = [
                                    'olt_id'        => $device->id,
                                    'mac_address'   => $mac['mac'],
                                    'vlan'          => $mac['vlan'] ?? null,
                                    'port'          => $mac['port'] ?? null,
                                    'type'          => $mac['type'] ?? null,
                                    'updated_at'    => now(),
                                    'created_at'    => now(),
                                ];
                            }

                            if (!empty($_mac_insert_data)) {

                                DB::table('olt_mac_table')->upsert(
                                    $_mac_insert_data,
                                    ['mac_address', 'vlan', 'olt_id'],
                                    [
                                        'port',
                                        'type',
                                        'updated_at'
                                    ]
                                );
                            }

                        } finally {

                            optional($lock)->release();
                        }

                    } catch (\Throwable $e) {

                        logger()->error('OLT Sync Error', [
                            'domain'    => request()->getHost(),
                            'olt_id' => $device->id,
                            'message' => $e->getMessage()
                        ]);

                        continue;
                    }
                }
            });
    }
}
