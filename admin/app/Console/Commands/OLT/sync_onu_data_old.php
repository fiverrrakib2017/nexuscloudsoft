<?php

namespace App\Console\Commands\OLT;

use App\Models\Olt_device;
use Illuminate\Console\Command;

class sync_onu_data_old extends Command
{
    protected $signature = 'app:sync_onu_dataaaa';

    protected $description = 'Sync ONU Data from BDCOM OLT';

    public function handle()
    {
        $this->info('-------Starting OLT Sync process via TELNET-------');

        $devices = Olt_device::where('status', 'active')->get();

        foreach ($devices as $device) {
            try {
                $fp = fsockopen(
                    $device->ip_address,
                    $device->port,
                    $errno,
                    $errstr,
                    10
                );

                if (! $fp) {
                    $this->error("Connection Failed : {$errstr}");
                    continue;
                }

                stream_set_timeout($fp, 10);

                // LOGIN
                $this->readUntil($fp, 'Username:');
                fwrite($fp, $device->username . "\r\n");

                $this->readUntil($fp, 'Password:');
                fwrite($fp, $device->password . "\r\n");

                $this->readUntilAny($fp, ['>', '#']);

                // If we are not already privileged, enter enable mode.
                fwrite($fp, "enable\r\n");
                $this->readUntil($fp, '#');

                // Disable pagination once.
                $this->sendCommand($fp, 'terminal length 0');

                // =========================
                // COMMANDS
                // =========================
                $onuInfoOutput  = $this->sendCommand($fp, 'show epon onu-information');
                $onuInfo        = $this->parseOnuInformation($onuInfoOutput);
                $activeOutput   = $this->sendCommand($fp, 'show epon active-onu');
                $inactiveOutput = $this->sendCommand($fp, 'show epon inactive-onu');
                $ponPorts = [];

                foreach ($onuInfo as $interface => $onu) {

                    if (
                        preg_match(
                            '/^(EPON\d+\/\d+):\d+$/i',
                            $interface,
                            $match
                        )
                    ) {
                        $ponPorts[strtoupper($match[1])] = true;
                    }
                }
                $opticalOutput = '';
                $configOutput  = '';
                foreach (array_keys($ponPorts) as $pon) {

                    $opticalOutput .= "\n" .
                        $this->sendCommand(
                            $fp,
                            "show epon onu-ctc-optical-transceiver-diagnosis interface {$pon}"
                        );

                    $configOutput .= "\n" .
                        $this->sendCommand(
                            $fp,
                            "show running-config interface {$pon}"
                        );
                }
                $macTableOutput  = $this->sendCommand($fp, 'show mac address-table');


                $active    = $this->parseActiveOnu($activeOutput);
                $inactive  = $this->parseInactiveOnu($inactiveOutput);
                $optical   = $this->parseOpticalPower($opticalOutput);
                $vlanId    = $this->parseVlan($configOutput);
                $macTable  = $this->parseMacAddressTable($macTableOutput);

                $onu_data=array();
                foreach ($onuInfo as $interface => $onu) {

                    $isActive   = isset($active[$interface]);
                    $isInactive = isset($inactive[$interface]);

                    $portMacs = collect($macTable)
                        ->where('port', strtoupper($interface))
                        ->values()
                        ->all();

                    $routerMac = $portMacs[0]['mac'] ?? null;
                    $formate_routerMac = $this->formate_mac_address($routerMac);

                    $status = $isActive
                        ? 'online'
                        : ($isInactive ? 'offline' : 'UNKNOWN');

                    $statusColor = match ($status) {
                        'ONLINE'  => 'green',
                        'OFFLINE' => 'red',
                        default   => 'yellow',
                    };

                    $distance = $active[$interface]['distance']
                        ?? $inactive[$interface]['distance']
                        ?? 'N/A';

                    $rxPower = $optical[$interface]['rx_power']
                        ?? '0';

                    $offlineReason = $inactive[$interface]['offline_reason']
                        ?? '-';

                    $onu_data[] = [
                        $onu['index_id'],
                        $interface,
                        $formate_routerMac,
                        $onu['onu_brand'],
                        $vlanId,
                        $distance . 'm',
                        $rxPower,
                        $optical[$interface]['tx_power'] ?? 'N/A',
                        $optical[$interface]['temperature'] ?? 'N/A',
                        $optical[$interface]['voltage'] ?? 'N/A',
                        $status,
                    ];
                }
                $this->table(
                    [
                        'ID',
                        'Interface',
                        'MAC',
                        'Brand',
                        'VLAN',
                        'Distance',
                        'RX(dBm)',
                        'TX(dBm)',
                        'Temp(°C)',
                        'Volt(V)',
                        'Status'
                    ],
                    $onu_data
                );

                fclose($fp);

                $this->info("OLT Sync Completed : {$device->ip_address}");
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
        }
    }

    private function readUntil($fp, $prompt, $timeout = 10)
    {
        return $this->readUntilAny($fp, [$prompt], $timeout);
    }

    private function readUntilAny($fp, array $prompts, $timeout = 10)
    {
        $buffer = '';
        $start = time();

        while ((time() - $start) < $timeout) {
            $data = fread($fp, 4096);

            if ($data !== false && $data !== '') {
                $buffer .= $data;

                foreach ($prompts as $prompt) {
                    if ($prompt !== '' && strpos($buffer, $prompt) !== false) {
                        return $buffer;
                    }
                }
            }

            usleep(200000);
        }

        return $buffer;
    }

    private function sendCommand($fp, $command)
    {
        fwrite($fp, $command . "\r\n");

        $buffer = '';
        $lastDataTime = microtime(true);

        while (true) {
            $data = fread($fp, 8192);

            if ($data !== false && $data !== '') {
                $buffer .= $data;
                $lastDataTime = microtime(true);
            }

            // Stop after 2 seconds without new data.
            if ((microtime(true) - $lastDataTime) >= 2) {
                break;
            }

            usleep(100000);
        }

        return $buffer;
    }

    private function parseOnuInformation($output)
    {
        $result = [];

        $lines = explode("\n", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (!preg_match('/^EPON\d+\/\d+:\d+/i', $line)) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            preg_match('/:(\d+)$/', $parts[0], $match);

            $result[$parts[0]] = [

                'index_id'      => $match[1] ?? null,

                'onu_brand'     => $parts[1] ?? null, // SMA

                'model_id'      => $parts[2] ?? null, // EPON

                //'mac'           => $parts[3] ?? null, // a07f.0310.3ae0

                'description'   => $parts[4] ?? null, // N/A

                'serial_number' => null,
            ];
        }

        return $result;
    }

    private function parseActiveOnu($output)
    {
        return $this->parseStatusList($output, 'online');
    }

    private function parseInactiveOnu($output)
    {
        return $this->parseStatusList($output, 'offline');
    }

    private function parseStatusList($output, $status)
    {
        $result = [];
        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || ! preg_match('/^EPON/i', $line)) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);
            $interface = strtoupper($parts[0]);

            $distance = null;

            // First try explicit "786m"
            if (preg_match('/(\d+)m\b/i', $line, $distanceMatch)) {

                $distance = (int) $distanceMatch[1];

            }
            // Fallback for BDCOM active-onu output
            elseif (isset($parts[4]) && is_numeric($parts[4])) {

                $distance = (int) $parts[4];
            }

            $reason = null;
            $lastOnline = null;
            $offlineTime = null;

            // Generic fallback: keep the raw text if the device output differs.
            // The command output format varies between firmware versions,
            // so we store the raw line and try to extract the most useful tail tokens.
            if (count($parts) >= 2) {
                $tail = array_slice($parts, 1);

                if ($status === 'offline') {
                    $reason = $tail[count($tail) - 1] ?? null;
                } else {
                    $lastOnline = $tail[count($tail) - 1] ?? null;
                }
            }

            $result[$interface] = [
                'status'        => $status,
                'distance'      => $distance,
                'last_online'   => $lastOnline,
                'offline_time'  => $offlineTime,
                'offline_reason'=> $reason,
                'raw'           => $line,
            ];
        }

        return $result;
    }

    private function parseOpticalPower($output)
    {
        $result = [];

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (!preg_match('/^epon\d+\/\d+:\d+/i', $line)) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            if (count($parts) < 6) {
                continue;
            }

            $interface = strtoupper($parts[0]);

            $result[$interface] = [

                'temperature' => (float) $parts[1],

                'voltage' => (float) $parts[2],

                'bias_current' => (float) $parts[3],

                'tx_power' => (float) $parts[4],

                'rx_power' => (float) $parts[5],
            ];
        }

        return $result;
    }

    private function parseVlan($output)
    {
        if (preg_match('/switchport\s+pvid\s+(\d+)/i', $output, $match)) {
            return $match[1];
        }

        return null;
    }
    private function parseMacAddressTable($output)
    {
        $result = [];

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (
                $line === '' ||
                str_contains($line, 'Mac Address Table') ||
                str_contains($line, 'Vlan') ||
                str_contains($line, '----')
            ) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            if (count($parts) < 4) {
                continue;
            }

            $port = strtoupper($parts[3]);

            if (!str_starts_with(strtolower($parts[3]), 'epon')) {
                continue;
            }

            $result[] = [
                'port' => $port,
                'vlan' => $parts[0],
                'mac'  => strtolower($parts[1]),
                'type' => strtoupper($parts[2]),
            ];
        }

        return $result;
    }
    private function formate_mac_address($mac_address){
        $get_mac_address = strtoupper(str_replace('.', '', $mac_address));

        return implode(':', str_split($get_mac_address, 2));
    }
}
