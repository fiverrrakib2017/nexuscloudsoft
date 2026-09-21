<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Router;
use App\Models\Radius\Radacct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Services\RouterosAPI;

class CheckCustomerStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $router_id;

    public function __construct($router_id)
    {
        $this->router_id = $router_id;
    }

    public function handle(): void
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 600);

        $router = Router::find($this->router_id);

        if (!$router) {
            return;
        }

        try {
            $API = new RouterosAPI();
            $API->timeout = 10;
            $API->attempts = 1;

            $activeUsers = collect();
            $pppSecrets = collect();
            $isConnected = false;

            /*-------------Mikrotik Connection--------------*/
            if ($API->connect($router->ip_address, $router->username, $router->password, (int)$router->port)) {
                $isConnected = true;

                /*-----------PPPoE Active Users-----*/
                $rawActive = $API->comm('/ppp/active/print');
                if (is_array($rawActive)) {
                    foreach ($rawActive as $item) {
                        if (isset($item['name'])) {
                            $activeUsers[strtolower(trim($item['name']))] = $item;
                        }
                    }
                }

                /*-------- PPPoE Secrets-----*/
                $rawSecrets = $API->comm('/ppp/secret/print');
                if (is_array($rawSecrets)) {
                    foreach ($rawSecrets as $item) {
                        if (isset($item['name'])) {
                            $pppSecrets[strtolower(trim($item['name']))] = $item;
                        }
                    }
                }

                $API->disconnect();
            }

            if (!$isConnected) {
                Log::error("Mikrotik Connection Failed for Router ID: {$router->id}");
                return;
            }
            $radiusUsernames = Customer::where('router_id', $router->id)
                ->where('connection_type', 'radius')
                ->where('is_delete', '0')
                ->whereNotIn('status', ['expired', 'disabled', 'discontinue'])
                ->pluck('username')
                ->map(fn($name) => strtolower(trim($name)))
                ->unique()
                ->values();

            $radiusSessions = collect();
            if ($radiusUsernames->isNotEmpty()) {
                $radiusSessions = Radacct::select('username', 'acctstarttime', 'acctstoptime')
                    ->whereIn('username', $radiusUsernames)
                    ->orderByDesc('acctstarttime')
                    ->get()
                    ->groupBy(function($item) {
                        return strtolower(trim($item->username));
                    });
            }

            /**----------------Database Query Optimize ---------------*/
            Customer::where('router_id', $router->id)
                ->where('is_delete', '0')
                ->whereNotIn('status', ['expired', 'disabled', 'discontinue'])
                ->chunk(100, function ($customers) use ($activeUsers, $pppSecrets, $radiusSessions) {

                    foreach ($customers as $customer) {
                        $dbUsername = strtolower(trim($customer->username));

                        /*--------- PPPoE Connection ---------*/
                        if ($customer->connection_type === 'pppoe') {

                            $isOnline = isset($activeUsers[$dbUsername]);
                            $secret = $pppSecrets[$dbUsername] ?? null;
                            $active = $activeUsers[$dbUsername] ?? null;

                            /*---------MAC Address-------*/
                            $macAddress = $active['caller-id']
                                ?? $active['mac-address']
                                ?? $secret['caller-id']
                                ?? $secret['last-caller-id']
                                ?? null;

                            $macAddress = $macAddress ? strtoupper(trim($macAddress)) : null;

                            /*----------- ONLINE -------------*/
                            if ($isOnline) {
                                if ($customer->status !== 'online' || $customer->mac_address !== $macAddress) {
                                    $customer->update([
                                        'status'      => 'online',
                                        'last_seen'   => null,
                                        'mac_address' => $macAddress
                                    ]);
                                }
                            }
                            /*----------- OFFLINE -------------*/
                            else {
                                $lastSeen = $customer->last_seen;
                                if ($secret && !empty($secret['last-logged-out'])) {
                                    try {
                                        $lastSeen = Carbon::parse($secret['last-logged-out'])->toDateTimeString();
                                    } catch (\Throwable $e) {
                                        $lastSeen = now()->toDateTimeString();
                                    }
                                }

                                if ($customer->status !== 'offline' || $customer->mac_address !== $macAddress) {
                                    $customer->update([
                                        'status'      => 'offline',
                                        'last_seen'   => $lastSeen,
                                        'mac_address' => $macAddress
                                    ]);
                                }
                            }
                        }

                        /*--------- Radius Connection ---------*/
                        elseif ($customer->connection_type === 'radius') {
                            $sessions = $radiusSessions->get($dbUsername);

                            if (!$sessions) {
                                if ($customer->status !== 'offline') {
                                    $customer->update(['status' => 'offline']);
                                }
                                continue;
                            }

                            $activeSession = $sessions->whereNull('acctstoptime')->first();

                            /*----------- ONLINE -------------*/
                            if ($activeSession) {
                                if ($customer->status !== 'online') {
                                    $customer->update(['status' => 'online']);
                                }
                            }
                            /*----------- OFFLINE -------------*/
                            else {
                                $lastSession = $sessions->first();
                                $lastSeen = $lastSession->acctstoptime
                                    ?? $lastSession->acctstarttime
                                    ?? $customer->last_seen;

                                if ($customer->status !== 'offline') {
                                    $customer->update([
                                        'status'    => 'offline',
                                        'last_seen' => $lastSeen
                                    ]);
                                }
                            }
                        }
                    }
                });

            Cache::flush();

        } catch (\Throwable $e) {
            Log::error(
                "Router ID ({$this->router_id}) Customer Status Job Failed : " . $e->getMessage()
            );
        }
    }
}
