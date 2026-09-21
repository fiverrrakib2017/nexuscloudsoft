<?php

namespace App\Services\OLT;

class VsolDriver
{
    protected TelnetClient $telnet;
    protected string $olt_type;
    protected string $enable_password;

    protected array $commands = [

        'gpon' => [
            'onu_info'  => 'show onu info all',
            'onu_state' => 'show onu state all',
        ],

        'epon' => [
            'onu_info'  => 'show onu basic-info',
            'onu_state' => 'show onu status',
        ],
    ];

    public function __construct(TelnetClient $telnet, string $oltType, string $enable_password)
    {
        $this->telnet = $telnet;
        $this->olt_type = strtolower($oltType);
        $this->enable_password = $enable_password;
        $this->boot();
    }

    protected function boot(): void
    {
        $this->telnet->executeCommand('enable');
        $this->telnet->executeCommand($this->enable_password);
        usleep(500000);
        $this->telnet->executeCommand('terminal length 0');
    }

    protected function enterPon(int $pon): void
    {
        $this->telnet->executeCommand('configure terminal');
        $interface_type= $this->olt_type ==='gpon' ? 'gpon'  :  'epon';
        $this->telnet->executeCommand("interface {$interface_type} 0/{$pon}");
    }

    protected function leavePon(): void
    {
        $this->telnet->executeCommand('end');
    }

    private function command(string $key): string
    {
        return $this->commands[$this->olt_type][$key];
    }

    public function getFullOnuData(): array
    {
        $macVlanMap     = $this->get_mac_and_vlan_table();
        $onuInfo        = $this->getOnuInformation();
        $onuState       = $this->getOnuState();

        $onuData = [];

        $opticalMap = [];

        if ($this->olt_type === 'epon') {

            $this->enterPon(1);

            $opticalMap = $this->parseEponOptical(
                $this->telnet->executeCommand('show onu opm-diag all', 30)
            );

            $this->leavePon();
        }

        foreach ($onuInfo as $interface => $onu) {
            $ponId  = $onu['pon_id'];
            $onuId  = $onu['index_id'];
            $interface_status = $onuState[$interface]['status'] ?? 'offline';

            $opticalOutput  = '';
            $distanceOutput = '';
            $routerMac      = $macVlanMap[$interface]['mac']?? '---';
            $vlan           = $macVlanMap[$interface]['vlan']?? '0';

            if ($this->olt_type === 'gpon') {
                if ($interface_status === 'online') {
                    $this->enterPon($ponId);

                    $opticalOutput = $this->telnet->executeCommand(sprintf('show onu %d optical_info', $onuId));

                    $distanceOutput = $this->telnet->executeCommand(sprintf('show onu %d distance', $onuId));

                    $this->leavePon();
                }

                $optical  = $this->parseOpticalPower($opticalOutput);
                $distance = $this->parseDistance($distanceOutput);

            }else {

                $optical = $opticalMap[$interface] ?? [];

                $distance = $onuState[$interface]['distance'] ?? 0;
            }

            // if(!empty($optical['rx_power'])){
            //     $status='online';
            // }else{
            //     $status='offline';
            // }


            $onuData[] = [
                $onuId,
                $interface,
                $routerMac ?? '---',
                $onu['onu_brand'],
                $vlan,
                $distance ? $distance . 'm' : '0',
                $optical['rx_power'] ?? '0',
                $optical['tx_power'] ?? '0',
                $optical['temperature'] ?? '0',
                $optical['voltage'] ?? '0',
                $interface_status,
            ];
        }

        return $onuData;
    }
    public function getSingleOnuSignal(  $ponId,  $onuId): array {

        try {
            $this->enterPon($ponId);

            if ($this->olt_type === 'gpon') {
                $opticalOutput = $this->telnet->executeCommand(
                    sprintf('show onu %d optical_info', $onuId)
                );

                $optical = $this->parseOpticalPower($opticalOutput);
            }else{
                $opticalOutput = $this->telnet->executeCommand('show onu opm-diag all',30);

                $opticalMap = $this->parseEponOptical($opticalOutput);

                $interface = sprintf('EPON0/%d:%d', $ponId, $onuId);

                $optical = $opticalMap[$interface] ?? [];
            }
            $this->leavePon();

            return [

                'success'  => true,

                'rx_power' => $optical['rx_power'] ?? null,

                'tx_power' => $optical['tx_power'] ?? null,

                'status'   => !empty($optical['rx_power']) ? 'online' : 'offline',
            ];

        } catch (\Throwable $e) {

            return [

                'success' => false,

                'error_message' => $e->getMessage()
            ];
        }
    }

    public function getOnuInformation(): array
    {
        $result = [];
        for ($pon = 1; $pon <= 8; $pon++) {

            $this->enterPon($pon);

            $output = $this->telnet->executeCommand($this->command('onu_info'),10);

            $this->leavePon();

            $result = array_merge($result,$this->parseOnuInformation($output));
        }
        return $result;
    }
     private function parseOnuInformation(string $output): array
    {
        $result = [];

        $output = $this->cleanOutput($output);

        $lines = preg_split('/\r?\n/', $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if ($this->olt_type === 'gpon') {

                if (
                    !preg_match(
                        '/^(GPON\d+\/\d+:\d+)\s+(.+?)\s+default\s+sn\s+([A-Za-z0-9]+)/i',
                        $line,
                        $match
                    )
                ) {
                    continue;
                }

                preg_match(
                    '/GPON\d+\/(\d+):(\d+)/',
                    $match[1],
                    $ids
                );

                $interface = strtoupper($match[1]);

                $serial = strtoupper($match[3]);

            } else {

                if (
                    !preg_match(
                        '/^(EPON\d+\/\d+:\d+)\s+(\S+)\s+(.+?)\s+([A-Za-z0-9]+)/i',
                        $line,
                        $match
                    )
                ) {
                    continue;
                }

                preg_match(
                    '/EPON\d+\/(\d+):(\d+)/',
                    $match[1],
                    $ids
                );

                $interface = strtoupper($match[1]);

                $serial = strtoupper($match[4]);
            }

            $result[$interface] = [

                'pon_id'   => (int)($ids[1] ?? 0),

                'index_id' => (int)($ids[2] ?? 0),

                'onu_brand' => substr($serial, 0, 4),
            ];
        }

        return $result;
    }
    private function parseEponOptical(string $output): array
    {
        $output = $this->cleanOutput($output);
        $result = [];

        foreach (preg_split('/\r?\n/', $output) as $line) {

            $line = trim($line);

            if (!preg_match(
                '/^(EPON\d+\/\d+:\d+)\s+' .
                '(-?\d+(?:\.\d+)?)\s+' .
                '(-?\d+(?:\.\d+)?)\s+' .
                '(-?\d+(?:\.\d+)?)\s+' .
                '(-?\d+(?:\.\d+)?)\s+' .
                '(-?\d+(?:\.\d+)?)/',
                $line,
                $m
            )) {
                continue;
            }

            $result[strtoupper($m[1])] = [

                'temperature' => $m[2],

                'voltage' => $m[3],

                'bias_current' => $m[4],

                'tx_power' => $m[5],

                'rx_power' => $m[6],
            ];
        }

        return $result;
    }

    public function getOnuState(): array
    {
        $result = [];

        for ($pon = 1; $pon <= 8; $pon++) {

            $this->enterPon($pon);

            $output = $this->telnet->executeCommand(
                $this->command('onu_state')
            );

            $this->leavePon();

            $result = array_merge(
                $result,
                $this->parseOnuState($output)
            );
        }

        return $result;
    }
    private function parseOnuState(string $output): array
    {
        $output = $this->cleanOutput($output);

        $result = [];

        $lines = preg_split('/\r?\n/', $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if ($this->olt_type === 'gpon') {

                if (!preg_match(
                    '/^(GPON\d+\/\d+:\d+)\s+\w+\s+\w+\s+(\w+)/i',
                    $line,
                    $match
                )) {
                    continue;
                }

                $status = strtolower($match[2]) === 'working'
                    ? 'online'
                    : 'offline';

                $result[strtoupper($match[1])] = [
                    'status' => $status,
                ];

            } else {

               if (!preg_match('/^(EPON\d+\/\d+:\d+)\s+'
                    .'(online|offline)\s+'
                    .'[0-9a-f:]+\s+'
                    .'(\d+)/i',
                    $line,$match)) {
                    continue;
                }

                $result[strtoupper($match[1])] = [
                    'status' => strtolower($match[2]),
                    'distance' => (int)$match[3],
                ];
            }
        }

        return $result;
    }

    private function parseOpticalPower(string $output): array
    {
        return [
            'rx_power' => preg_match('/Rx optical level\(ONU\)\s*:\s*(-?\d+\.\d+)/i', $output, $rx) ? (float)$rx[1] : null,
            'tx_power' => preg_match('/Tx optical level\s*:\s*(-?\d+\.\d+)/i', $output, $tx) ? (float)$tx[1] : null,
            'voltage' => preg_match('/Power feed voltage\s*:\s*(-?\d+\.\d+)/i', $output, $volt) ? (float)$volt[1] : null,
            'temperature' => preg_match('/Temperature\s*:\s*(-?\d+\.\d+)/i', $output, $temp) ? (float)$temp[1] : null,
        ];
    }

    private function parseDistance(string $output): ?float
    {
        if (preg_match('/Distance:\s*(\d+(?:\.\d+)?)m/i', $output, $match)) {
            return (float)$match[1];
        }
        return null;
    }


    private function get_mac_and_vlan_table()
    {
        $this->telnet->executeCommand('configure terminal');

        $output = $this->telnet->executeCommand('show mac address-table', 5);

        $result = [];

        $lines = preg_split('/\r?\n/', $output);

        foreach ($lines as $line) {

            if (
                preg_match(
                    '/^\s*(\d+)\s+' .
                    '([0-9A-F:]+)\s+' .
                    'Dynamic\s+' .
                    '(GPON|EPON)\s*' .
                    '0\/(\d+)' .
                    '(?::(\d+))?/i',
                    $line,
                    $m
                )
            ) {

                $interface = strtoupper($m[3]) . '0/' . $m[4];

                if (isset($m[5]) && $m[5] !== '') {
                    // 012 -> 12
                    $interface .= ':' . (int)$m[5];
                }

                $result[$interface] = [

                    'vlan' => (int)$m[1],

                    'mac' => strtoupper(
                        preg_replace(
                            '/(..)(..)(..)(..)(..)(..)/',
                            '$1:$2:$3:$4:$5:$6',
                            str_replace(':', '', $m[2])
                        )
                    ),
                ];
            }
        }

        return $result;
    }

    private function cleanOutput(string $output): string
    {
        $output = preg_replace('/\\\\e\[[0-9;]*[A-Za-z]/', ' ', $output);
        $output = preg_replace('/\x1B\[[0-9;]*[A-Za-z]/', ' ', $output);
        return $output;
    }
}
