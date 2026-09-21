<?php
namespace App\Console\Commands\OLT;
use App\Models\Olt_device;
use App\Services\OLT\BdcomDriver;
use App\Services\OLT\VsolDriver;
use App\Services\OLT\FocuscomDriver;
use App\Services\OLT\TelnetClient;
use Illuminate\Console\Command;
use App\Models\Router as Mikrotik_router;
use App\Models\Onu;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Services\RouterosAPI;
use App\Models\Radius\Radacct;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class sync_onu_data extends Command
{
    protected $signature = 'app:sync_onu_data';

    protected $description = '------Sync onu data from OLT------';
    public function handle(){
        $this->info( '-------Starting OLT -------');
        $devices = Olt_device::where('status','active')->get();
        foreach ($devices as $device) {
             try {

                $telnet = new TelnetClient(
                    $device->ip_address,
                    $device->port,
                    $device->username,
                    $device->password
                );

                $telnet->connect()->login();

                $driver = match (strtoupper($device->brand)) {

                    'BDCOM' => new BdcomDriver($telnet,strtolower($device->mode)),

                    'VSOL' => new VsolDriver($telnet,strtolower($device->mode),$device->password),

                    'FOCUSCOM' => new FocuscomDriver($device->ip_address,$device->port,$device->username, $device->password,$device->mode),

                    default => null
                };
                $_onu_data = $driver->getFullOnuData();
                /*----------Delete Onu Table Before Insert--------*/
                Onu::where('olt_id',$device->id)->delete();
                $this->_onu_data_insert($device->id,$_onu_data);

                $this->info("{$device->brand} Sync Completed. Total ONU: ". count($_onu_data));



            } catch (\Throwable $e) {

                $this->error(
                    "[{$device->brand}] " . $e->getMessage()
                );
            }
        }
    }

    private function _onu_data_insert(int $olt_device_id, array $onu_data): void
    {
        /*---------Check Onu Data Exist-----------*/
        if (empty($onu_data)) {
            return;
        }

        $online_mac_username_map = [];

        $branch_user_id = Auth::guard('admin')->user()->pop_id ?? null;
        $routers = Mikrotik_router::when($branch_user_id, function($q) use ($branch_user_id) {
            return $q->where('pop_id', $branch_user_id);
        })->get();

        foreach ($routers as $routerInfo) {
            try {
                $API = new RouterosAPI();
                $API->debug = false;
                $API->timeout = 2;

                if ($API->connect($routerInfo->ip_address, $routerInfo->username, $routerInfo->password, (int) ($routerInfo->port ?? 8728))) {
                    $rawActive = $API->comm('/ppp/active/print');
                    if (is_array($rawActive)) {
                        foreach ($rawActive as $row) {
                            if (!empty($row['caller-id']) && !empty($row['name'])) {
                                $clean_mac = strtolower(trim($row['caller-id']));
                                $online_mac_username_map[$clean_mac] = strtolower(trim($row['name']));
                            }
                        }
                    }
                    $API->disconnect();
                }
            } catch (\Exception $e) {
                Log::warning("ONU Sync MikroTik Map Connection Failed: " . $e->getMessage());
            }
        }

        if (Schema::hasTable('radacct')) {
            try {
                $radiusActiveSessions = Radacct::whereNull('acctstoptime')
                    ->whereNotNull('callingstationid')
                    ->select('username', 'callingstationid')
                    ->get();

                foreach ($radiusActiveSessions as $session) {
                    $clean_mac = strtolower(trim($session->callingstationid));
                    if (!isset($online_mac_username_map[$clean_mac])) {
                        $online_mac_username_map[$clean_mac] = strtolower(trim($session->username));
                    }
                }
            } catch (\Exception $e) {
                Log::warning("ONU Sync Radius Map Query Failed: " . $e->getMessage());
            }
        }

        $existing_onus = Onu::where('olt_id', $olt_device_id)->get()->groupBy(function($item) {
            return $item->interface_name;
        });
        foreach ($onu_data as $row) {

            $onuId     = $row[0] ?? null;
            $interface = $row[1] ?? null;
            $mac       = !empty($row[2]) ? strtolower(trim($row[2])) : null;
            $brand     = $row[3] ?? null;
            $vlan      = $row[4] ?? null;
            $distance  = $row[5] ?? null;
            $rx        = $row[6] ?? null;
            $tx        = $row[7] ?? null;
            $temp      = $row[8] ?? null;
            $volt      = $row[9] ?? null;
            $status    = $row[10] ?? 'offline';

            if (!$interface) continue;
            $onu = isset($existing_onus[$interface]) ? $existing_onus[$interface]->first() : null;

            if (!$onu) {
                $onu = new Onu();
                $onu->olt_id = $olt_device_id;
                $onu->interface_name = $interface;
            }

            $customer_id = null;

            if ($mac && isset($online_mac_username_map[$mac])) {
                $username = $online_mac_username_map[$mac];
                $customer = Customer::where(DB::raw('LOWER(username)'), $username)->where('is_delete', 0)->first();
                if ($customer) {
                    $customer_id = $customer->id;
                }
            }
            $onu->customer_id = $customer_id;

            $onu->onu_id        = $onuId;
            $onu->name          = $brand;
            $onu->serial_number = $serial_number ?? "STC-".rand(584908, 909489);

            if (!empty($mac)) {
                $onu->mac_address = strtoupper($mac);
            }

            $onu->pon_port       = explode(':', $interface)[0] ?? null;
            $onu->vlan_id        = $vlan;
            $onu->status         = $status;

            $onu->rx_power      = is_numeric($rx) ? $rx : null;
            $onu->tx_power      = is_numeric($tx) ? $tx : null;
            $onu->temperature   = is_numeric($temp) ? $temp : null;
            $onu->voltage       = is_numeric($volt) ? $volt : null;

            $onu->distance      = is_numeric(str_replace('m', '', (string) $distance)) ? (int) str_replace('m', '', $distance) : null;
            $onu->last_updated_at = now();

            if ($status === 'online') {
                $onu->last_online = now();
            } else {
                $onu->offline_time = now();
            }

            $onu->save();
        }
    }

    private function _onu_data_insertss( int $olt_device_id,array $onu_data): void {
        /*---------Check Onu Data Exist-----------*/
        if (empty($onu_data)) {
            return;
        }
        $get_all_mac_address = array_filter(array_column($onu_data, 2));
        /*--------Create Customer Mac address Map-=------------*/
        $customer_mac_address_map = Customer::whereIn('mac_address', $get_all_mac_address)->pluck('id', 'mac_address')->toArray();

        $existing_onus = Onu::where('olt_id', $olt_device_id)->get()->groupBy(function($item) {
                            return $item->interface_name;
                        });
        foreach ($onu_data as $row) {

            $onuId     = $row[0] ?? null;
            $interface = $row[1] ?? null;
            $mac       = $row[2] ?? null;
            $brand     = $row[3] ?? null;
            $vlan      = $row[4] ?? null;
            $distance  = $row[5] ?? null;
            $rx        = $row[6] ?? null;
            $tx        = $row[7] ?? null;
            $temp      = $row[8] ?? null;
            $volt      = $row[9] ?? null;
            $status    = $row[10] ?? 'offline';

            if (!$interface) continue;
            $onu = isset($existing_onus[$interface]) ? $existing_onus[$interface]->first() : null;

            if (!$onu) {
                $onu = new Onu();
                $onu->olt_id = $olt_device_id;
                $onu->interface_name = $interface;
            }
            $customer_id = $customer_mac_address_map[$mac] ?? null;
            /*--------Get Customer ID if Exist----------*/

            if (!empty($customer_id)) {
                $onu->customer_id = $customer_id;
            }

            $onu->onu_id        = $onuId;
            $onu->name          = $brand;
            $onu->serial_number = $serial_number ?? "STC-".rand(584908, 909489);

            if (!empty($mac)) {
                $onu->mac_address = $mac;
            }

            $onu->pon_port      = explode(':', $interface)[0] ?? null;
            $onu->vlan_id       = $vlan;

            $onu->status        = $status;

            $onu->rx_power      = is_numeric($rx) ? $rx : null;
            $onu->tx_power      = is_numeric($tx) ? $tx : null;
            $onu->temperature   = is_numeric($temp) ? $temp : null;
            $onu->voltage       = is_numeric($volt) ? $volt : null;

            $onu->distance      = is_numeric(str_replace('m', '', (string) $distance))? (int) str_replace('m', '', $distance): null;

            $onu->last_updated_at = now();

            if ($status === 'online') {

                $onu->last_online = now();

            } else {

                $onu->offline_time = now();
            }

            $onu->save();
        }
    }
}
