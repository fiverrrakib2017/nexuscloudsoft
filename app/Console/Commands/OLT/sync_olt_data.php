<?php

namespace App\Console\Commands\OLT;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Olt_device;
use SNMP;
use Exception;
class sync_olt_data extends Command
{
    protected $signature = 'olt:pull';

    protected $description = 'Poll OLTs over SNMP and write into onus & olt_laser_logs using exact index matching.';

    public function handle()
    {
        $this->info('Starting OLT Sync process...');

        // $devices = Olt_device::where('status', 'active')->get();
        $devices = [
            (object)[
                'name' => 'BDCOM OLT',
                'ip_address' => '103.248.206.108',
                'port' => 3000,
                'brand' => 'BDCOM',
                'snmp_community' => 'venus_olt',
            ],
            (object)[
                'name' => 'BDCOM OLT',
                'ip_address' => '103.112.207.164',
                'port' => 9055,
                'brand' => 'BDCOM',
                'snmp_community' => 'YETFIX',
            ],
        ];
        // if ($devices->isEmpty()) {
        //     $this->warn('No active OLT devices found.');
        //     return self::SUCCESS;
        // }
        foreach($devices as $device){
            /*-----------------Connecting OLT---------------------------*/
            $this->info("Connecting to OLT: {$device->name} ({$device->ip_address}:{$device->port})");
            $brand = strtolower($device->brand ?? 'bdcom');
            $mac_address_oids   = '';
            $serial_number_oids = '';
            $rx_power_oids      = '';
            $onu_brand_oids     = '';
            $distance_oids      = '';
            $vlan_oids          = '';
            $offline_reason_oids= '';

            if ($brand == 'bdcom') {
                $mac_address_oids    = '.1.3.6.1.4.1.3320.101.10.1.1.3';
                $rx_power_oids       = '.1.3.6.1.4.1.3320.101.10.5.1.5';
                $distance_oids       = '1.3.6.1.4.1.3320.101.10.1.1.27';
                $vlan_oids           = '1.3.6.1.4.1.3320.101.12.1.1.3';
                $offline_reason_oids = '1.3.6.1.4.1.3320.101.11.1.1.10';
                $onu_brand_oids       = '1.3.6.1.4.1.3320.101.10.1.1.1';
                $serial_number_oids  = '1.3.6.1.4.1.3320.101.10.1.1.5';

            } elseif ($brand == 'vsol') {
               $mac_address_oids    = '1.3.6.1.4.1.37950.1.1.5.12.1.25';
               $rx_power_oids       = '1.3.6.1.4.1.37950.1.1.5.12.2.1.2';
               $distance_oids       = '1.3.6.1.4.1.37950.x.x.x';
               $vlan_oids           = '1.3.6.1.4.1.37950.y.y.y';
               $offline_reason_oids = '1.3.6.1.4.1.37950.z.z.z';

            } elseif ($brand == 'focuscom') {
                $mac_address_oids    = '1.3.6.1.4.1.51170.1.1.1.1.1.2';
                $rx_power_oids       = '1.3.6.1.4.1.51170.1.1.1.3.1.2';
                $distance_oids       = '';
                $vlan_oids           = '';
                $offline_reason_oids = '';
            } else {
                $this->error("Unknown OLT brand [{$brand}] for {$device->name}. Skipping...");
                continue;
            }




            $snmp = new SNMP(
                    SNMP::VERSION_2C,
                    $device->ip_address . ':' . ($device->port ?? 161),
                    $device->snmp_community,
                    3000000,
                    1
                );
            $snmp->valueretrieval = SNMP_VALUE_PLAIN;
            $snmp->oid_output_format = SNMP_OID_OUTPUT_NUMERIC;
            $snmp->quick_print = 1;

            $sysDescr = @$snmp->get('.1.3.6.1.2.1.1.1.0');
            if (!$sysDescr) {
                $this->error("Failed to get System Description.");
                continue;
            }

            $this->line("<fg=green>OLT Info Found:</> " . trim($sysDescr));
            /*-----Get All Port List-------------*/
            $interfaces = @$snmp->walk('.1.3.6.1.2.1.2.2.1.2');
            if(empty($interfaces) || !is_array($interfaces)){
                $this->warn("No interfaces found on this OLT.");
                continue;
            }
            $this->info("Found " . count($interfaces) . " interfaces/ports. Listing them below:");
            /*--------Port And Index-------------*/
            $onu_data=array();
            foreach ($interfaces as $oidKey => $interfaceName) {
               $cleanName = trim(str_replace('"', '', $interfaceName));
                /*--------bdcom,vsol Aligment----*/
                if (strpos($cleanName, ':') !== false || strpos(strtoupper($cleanName), 'ONU') !== false) {
                    /*------------ OID Key get Index id-----*/
                    $parts = explode('.', $oidKey);
                    $indexId = end($parts);
                    /*-------Push Fresh Array----------*/
                    $onu_data[$indexId] = [
                        'index_id'          => $indexId,
                        'interface_name'    => $cleanName,
                        'mac'               => '',
                        'serial_number'     => '',
                        'rx_power'          => '',
                        'onu_status'        => '',
                        'onu_brand'         => '',
                        'distance'          => '',
                        'vlan_id'           => '',
                        'offline_reason'    => '',
                        'last_online'       => null,
                        'offline_time'      => null,
                    ];
                }
            }

            /*-----------Get All Mac Address-----------*/
            if (!empty($mac_address_oids)) {
                $rawMacs = @$snmp->walk($mac_address_oids);

                if (!empty($rawMacs) && is_array($rawMacs)) {
                    foreach ($rawMacs as $oidKey => $rawMacValue) {
                        $parts = explode('.', $oidKey);
                        $indexId = end($parts);

                        if (isset($onu_data[$indexId])) {
                            $macHex = bin2hex($rawMacValue);
                            $_formatted_mac_address = strtoupper(implode(':', str_split($macHex, 2)));

                            $onu_data[$indexId]['mac'] = $_formatted_mac_address;
                        }
                    }
                }
            }
            /*-----------Get All Onu Serial Number -----------*/
            if (!empty($serial_number_oids)) {
                usleep(200000);
                $rawSerials = @$snmp->walk($serial_number_oids);

                if (!empty($rawSerials) && is_array($rawSerials)) {
                    foreach ($rawSerials as $oidKey => $rawSerialValue) {
                        $parts = explode('.', trim($oidKey));
                        $indexId = end($parts);

                        if (isset($onu_data[$indexId])) {
                            $hexString = bin2hex($rawSerialValue);
                            if (strlen($hexString) >= 16) {
                                $vendorHex = substr($hexString, 0, 8);
                                $vendorAscii = pack("H*", $vendorHex);
                                $serialExtension = strtoupper(substr($hexString, 8));
                                $onu_data[$indexId]['serial_number'] = trim($vendorAscii) . $serialExtension;
                            } else {
                                $onu_data[$indexId]['serial_number'] = strtoupper($hexString);
                            }
                        }
                    }
                }
            }
            /*-----------Get All RX Power -----------*/
            if (!empty($rx_power_oids)) {
                $this->comment("Fetching Live Rx Power");
                /*-----------Break This Olt -----------*/
                usleep(500000);

                try {
                    $raw_signals = @$snmp->walk($rx_power_oids);
                } catch (\Exception $snmpException) {
                    $raw_signals = [];
                }

                if (!empty($raw_signals) && is_array($raw_signals)) {
                    foreach ($raw_signals as $oidKey => $rawValue) {

                        $cleanOidKey = trim($oidKey);

                        $parts = explode('.', $cleanOidKey);

                        $indexId = end($parts);

                        if (isset($onu_data[$indexId])) {
                            $signal = intval(trim($rawValue));

                            /*---------- Brand Wise Signal Logic Calculation ------------*/
                            if ($brand == 'bdcom') {
                                if ($signal < 0) {
                                    $_calculate_signal = ($signal / 10);
                                    $onu_data[$indexId]['rx_power']   = $_calculate_signal . " dBm";
                                    $onu_data[$indexId]['last_online'] = now();
                                    if ($_calculate_signal <= -30.0) {
                                        $onu_data[$indexId]['onu_status'] = 'LOSS';
                                    } else {
                                        $onu_data[$indexId]['onu_status'] = 'ONLINE';
                                    }
                                }else{
                                    $onu_data[$indexId]['rx_power']    = 'Offline';
                                    $onu_data[$indexId]['offline_time'] = now();
                                }

                            } elseif ($brand == 'vsol') {
                                if ($signal != 0 && $signal != 65535) {
                                    $_calculate_signal = ($signal > 32767 ? ($signal - 65536) / 100 : $signal / 100);
                                    $onu_data[$indexId]['rx_power']   = $_calculate_signal . " dBm";
                                    $onu_data[$indexId]['onu_status'] = 'ONLINE';
                                    $onu_data[$indexId]['last_online'] = now();
                                } else {
                                    $onu_data[$indexId]['rx_power']    = 'Offline';
                                    $onu_data[$indexId]['onu_status'] = 'OFFLINE';
                                    $onu_data[$indexId]['offline_time'] = now();
                                }
                            } else {
                                $onu_data[$indexId]['rx_power']   = $signal . " dBm";
                            }
                        }
                    }
                }
            }

            /*----------- Show Onu Vendor Name -----------*/
            if (!empty($onu_brand_oids)) {
                usleep(500000);
                $raw_onu_name = @$snmp->walk($onu_brand_oids);

                if (!empty($raw_onu_name) && is_array($raw_onu_name)) {
                    foreach ($raw_onu_name as $oidKey => $rawValue) {

                        $cleanOidKey = trim($oidKey);
                        $parts       = explode('.', $cleanOidKey);
                        $indexId     = end($parts);

                        if (isset($onu_data[$indexId])) {
                            $rawVendorString = trim(str_replace('"', '', $rawValue));

                            switch ($rawVendorString) {
                                case 'HWTC':
                                    $onu_data[$indexId]['onu_brand'] = 'Huawei';
                                    break;
                                case 'XDBC':
                                case 'EDBC':
                                case 'DBCE':
                                    $onu_data[$indexId]['onu_brand'] = 'DBC';
                                    break;
                                case 'VSOL':
                                    $onu_data[$indexId]['onu_brand'] = 'V-SOL';
                                    break;
                                case 'RTEG':
                                    $onu_data[$indexId]['onu_brand'] = 'Realtek';
                                    break;
                                case 'SMA ':
                                case 'SMA':
                                    $onu_data[$indexId]['onu_brand'] = 'Syrotech';
                                    break;
                                case 'XPON':
                                case 'FTTH':
                                    $onu_data[$indexId]['onu_brand'] = 'Generic XPON';
                                    break;
                                case '----':
                                    $onu_data[$indexId]['onu_brand'] = 'Unknown';
                                    break;
                                default:
                                    $onu_data[$indexId]['onu_brand'] = $rawVendorString;
                                    break;
                            }
                        }
                    }
                }
            }
            /*----------- Get All Onu Distance -----------*/
            if (!empty($distance_oids)) {
                usleep(200000);
                $rawDistances = @$snmp->walk($distance_oids);

                if (!empty($rawDistances) && is_array($rawDistances)) {
                    foreach ($rawDistances as $oidKey => $rawValue) {
                        $parts = explode('.', trim($oidKey));
                        $indexId = end($parts);

                        if (isset($onu_data[$indexId])) {
                            $meter = intval(trim($rawValue));
                            $onu_data[$indexId]['distance'] = ($meter > 0) ? ($meter / 1000) . " KM" : "0 KM";
                        }
                    }
                }
            }

            /*----------- Get All Onu Vlan ID -----------*/
            if (!empty($vlan_oids)) {
                usleep(200000);
                $rawVlans = @$snmp->walk($vlan_oids);

                if (!empty($rawVlans) && is_array($rawVlans)) {
                    foreach ($rawVlans as $oidKey => $rawValue) {

                        $cleanOidKey = trim($oidKey);

                        $parts = explode('.', $cleanOidKey);
                        $countParts = count($parts);

                        if ($countParts >= 2) {
                            $indexId = $parts[$countParts - 2];
                            $lanPort = end($parts);

                            if (isset($onu_data[$indexId])) {
                                $detectedVlan = intval(trim(str_replace('"', '', $rawValue)));

                                if ($onu_data[$indexId]['vlan_id'] === '' || $lanPort == 1) {
                                    $onu_data[$indexId]['vlan_id'] = $detectedVlan;
                                }
                            }
                        }
                    }
                }
            }

            /*----------- Get All Onu Offline Reason -----------*/
            if (!empty($offline_reason_oids)) {
                usleep(200000);
                $rawReasons = @$snmp->walk($offline_reason_oids);

                if (!empty($rawReasons) && is_array($rawReasons)) {
                    foreach ($rawReasons as $oidKey => $rawValue) {
                        $cleanOidKey = trim($oidKey);
                        $parts = explode('.', $cleanOidKey);
                        $countParts = count($parts);

                        if ($countParts >= 1) {
                            $indexId = end($parts);

                            if (!isset($onu_data[$indexId]) && $countParts >= 2) {
                                $indexId = $parts[$countParts - 2];
                            }

                            if (isset($onu_data[$indexId])) {
                                $reasonCode = intval(trim($rawValue));

                                /*---------- Brand Wise Offline Reason Mapping ------------*/
                                if ($brand == 'bdcom') {
                                    switch ($reasonCode) {
                                        case 1:
                                            $onu_data[$indexId]['offline_reason'] = 'Fiber Cut / LOS';
                                            break;
                                        case 2:
                                        case 3:
                                            $onu_data[$indexId]['offline_reason'] = 'Power Cut / Dying Gasp';
                                            break;
                                        case 4:
                                            $onu_data[$indexId]['offline_reason'] = 'Manual Deregistered';
                                            break;
                                        default:
                                            if (isset($onu_data[$indexId]['onu_status']) && $onu_data[$indexId]['onu_status'] === 'ONLINE') {
                                                $onu_data[$indexId]['offline_reason'] = '---';
                                            } else {
                                                $onu_data[$indexId]['offline_reason'] = 'Offline (Code: ' . $reasonCode . ')';
                                            }
                                            break;
                                    }
                                } else {
                                    $onu_data[$indexId]['offline_reason'] = 'Reason Code: ' . $reasonCode;
                                }
                            }
                        }
                    }
                }
            }


            /*----------- Show Output on Terminal -----------*/
            foreach ($onu_data as $id => $data) {
                $displaySignal = (!empty($data['rx_power'])) ? $data['rx_power'] : 'Offline';
                $displayVlan   = ($data['vlan_id'] !== '') ? $data['vlan_id'] : '---';
                $displayReason = (!empty($data['offline_reason'])) ? $data['offline_reason'] : '---';
                $displaySerial = (!empty($data['serial_number'])) ? $data['serial_number'] : '---';
                $displayDist   = (!empty($data['distance'])) ? $data['distance'] : '0 KM';
                $displayBrand  = (!empty($data['onu_brand'])) ? $data['onu_brand'] : 'Unknown';

                $this->line(
                    "-> Index: <fg=yellow>" . str_pad($id, 4) . "</> | " .
                    "Port: <fg=cyan>" . str_pad($data['interface_name'], 12) . "</> | " .
                    "MAC: <fg=green>" . str_pad($data['mac'], 17) . "</> | " .
                    "SN: <fg=gray>" . str_pad($displaySerial, 14) . "</> | " .
                    "Brand: <fg=cyan>" . str_pad($displayBrand, 12) . "</> | " .
                    "VLAN: <fg=yellow>" . str_pad($displayVlan, 5) . "</> | " .
                    "Signal: <fg=magenta>" . str_pad($displaySignal, 10) . "</> | " .
                    "Dist: <fg=blue>" . str_pad($displayDist, 7) . "</> | " .
                    "Reason: <fg=red>{$displayReason}</>"
                );
            }
        }
    }
}
