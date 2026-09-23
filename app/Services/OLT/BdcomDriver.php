<?php

namespace App\Services\OLT;

class BdcomDriver
{
    protected TelnetClient $telnet;

    protected string $olt_type;

    protected array $commands = [

        'epon' => [

            'onu_info'       => 'show epon onu-information',
            'active_onu'     => 'show epon active-onu',
            'inactive_onu'   => 'show epon inactive-onu',
            'optical'        => 'show epon onu-ctc-optical-transceiver-diagnosis interface %s',
            'running_config' => 'show running-config interface %s',
            'mac_table'      => 'show mac address-table',
        ],

        'gpon' => [

            'onu_info'       => 'show gpon onu-information',
            'active_onu'     => 'show gpon active-onu',
            'inactive_onu'   => 'show gpon inactive-onu',
            'optical'        => 'show gpon onu-optical-transceiver-diagnosis interface %s',
            'running_config' => 'show running-config interface %s',
            'mac_table'      => 'show mac address-table',
        ],
    ];

    public function __construct(TelnetClient $telnet,string $oltType) {
        $this->telnet   = $telnet;
        $this->olt_type = strtolower($oltType);

        $this->boot();
    }

    protected function boot(): void
    {
        $this->telnet->executeCommand('enable');
        $this->telnet->executeCommand('terminal length 0');
    }
    public function getFullOnuData(): array
    {
        $onuInfo    = $this->getOnuInformation();
        $active     = $this->getActiveOnu();
        $inactive   = $this->getInactiveOnu();
        $macTable   = $this->getMacTable();

        $ponPorts = [];

        foreach ($onuInfo as $interface => $onu) {

            if (
                preg_match(
                    '/^(EPON\d+\/\d+|GPON\d+\/\d+)/i',
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
                $this->telnet->executeCommand(
                    sprintf(
                        $this->command('optical'),
                        $pon
                    )
                );

            $configOutput .= "\n" .
                $this->telnet->executeCommand(
                    sprintf(
                        $this->command('running_config'),
                        $pon
                    )
                );
        }

        $optical = $this->parseOpticalPower(
            $opticalOutput
        );

        $vlanId = $this->parseVlan(
            $configOutput
        );

        $onuData = [];

        foreach ($onuInfo as $interface => $onu) {

            $isActive   = isset($active[$interface]);
            $isInactive = isset($inactive[$interface]);

            $portMacs = collect($macTable)
                ->where('port', strtoupper($interface))
                ->values()
                ->all();

            $routerMac = $portMacs[0]['mac'] ?? null;

            $status = $isActive
                ? 'online'
                : ($isInactive ? 'offline' : 'unknown');

            $distance = $active[$interface]['distance']
                ?? $inactive[$interface]['distance']
                ?? 'N/A';

            $rxPower = $optical[$interface]['rx_power']
                ?? 'N/A';

            $onuData[] = [

                $onu['index_id'],

                $interface,

                $routerMac
                    ? $this->formate_mac_address($routerMac)
                    : null,

                $onu['onu_brand'],

                $vlanId,

                $distance . 'm',

                $rxPower,

                $optical[$interface]['tx_power']
                    ?? 'N/A',

                $optical[$interface]['temperature']
                    ?? 'N/A',

                $optical[$interface]['voltage']
                    ?? 'N/A',

                $status,
            ];
        }

        return $onuData;
    }
    public function getSingleOnuSignal(string $interface): array
    {
        try {
            $status = 'offline';
            $opticalOutput = '';
            if (preg_match('/^(EPON\d+\/\d+|GPON\d+\/\d+)/i', $interface,$match)) {
                $ponPort = strtoupper($match[1]);
                $opticalOutput = $this->telnet->executeCommand(
                    sprintf( $this->command('optical'),$ponPort )
                );
            }
            $opticalData = $this->parseOpticalPower($opticalOutput);
            $optical = $opticalData[strtoupper($interface)] ?? [];
            if(!empty($optical)){
                $status='online';
            }
            return [

                'success'     => true,

                'rx_power'    => $optical['rx_power'] ?? null,

                'tx_power'    => $optical['tx_power'] ?? null,

               'status'      => $status,
            ];

        } catch (\Throwable $e) {

            return [

                'success' => false,

                'error_message' => $e->getMessage()
            ];
        }
    }

    protected function command(string $key): string
    {
        if (!isset($this->commands[$this->olt_type][$key])) {
            throw new \Exception(
                "Command {$key} not found for {$this->olt_type}"
            );
        }

        return $this->commands[$this->olt_type][$key];
    }

    public function getOnuInformation(): array
    {
        $output = $this->telnet->executeCommand(
            $this->command('onu_info')
        );

        return $this->parseOnuInformation($output);
    }

    public function getActiveOnu(): array
    {
        $output = $this->telnet->executeCommand(
            $this->command('active_onu')
        );

        return $this->parseStatusList(
            $output,
            'online'
        );
    }

    public function getInactiveOnu(): array
    {
        $output = $this->telnet->executeCommand(
            $this->command('inactive_onu')
        );

        return $this->parseStatusList(
            $output,
            'offline'
        );
    }

    public function getMacTable(): array
    {
        $output = $this->telnet->executeCommand(
            $this->command('mac_table')
        );
        return $this->parseMacAddressTable($output);
    }

    private function parseOnuInformation(string $output): array
    {
        $result = [];

        $lines = explode("\n", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (
                !preg_match(
                    '/^(EPON|GPON)\d+\/\d+:\d+/i',
                    $line
                )
            ) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            preg_match('/:(\d+)$/', $parts[0], $match);

            $result[$parts[0]] = [

                'index_id'      => $match[1] ?? null,
                'onu_brand'     => $parts[1] ?? null,
                'model_id'      => $parts[2] ?? null,
                'onu_mac'       => $parts[3] ?? null,
                'description'   => $parts[4] ?? null,
                'serial_number' => null,
            ];
        }

        return $result;
    }

    private function parseStatusList( string $output,string $status): array {

        $result = [];

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (
                $line === '' ||
                !preg_match('/^(EPON|GPON)\d+\/\d+:\d+/i', $line)
            ) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            $interface = strtoupper($parts[0]);

            $distance = null;

            if ($this->olt_type === 'gpon') {

                // GPON: last column = 1489.1
                if (
                    preg_match(
                        '/(\d+(?:\.\d+)?)\s*$/',
                        $line,
                        $distanceMatch
                    )
                ) {
                    $distance = (float) $distanceMatch[1];
                }

            } else {
                if (
                    preg_match(
                        '/(\d+)m\b/i',
                        $line,
                        $distanceMatch
                    )
                ) {

                    $distance = (int) $distanceMatch[1];

                } elseif (
                    isset($parts[4]) &&
                    is_numeric($parts[4])
                ) {

                    $distance = (int) $parts[4];
                }
            }

            $result[$interface] = [
                'status'   => $status,
                'distance' => $distance,
                'raw'      => $line,
            ];
        }

        return $result;
    }

    private function parseMacAddressTable(string $output): array {

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

            // GPON: GPON0/1:44-1 => GPON0/1:44
            if ($this->olt_type === 'gpon') {
                $port = preg_replace('/-\d+$/', '', $port);
            }

            $result[] = [

                'vlan' => $parts[0],
                'mac'  => strtolower($parts[1]),
                'type' => strtoupper($parts[2]),
                'port' => $port,
            ];
        }

        return $result;
    }
    private function parseOpticalPower(string $output): array
    {
        $result = [];

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (!preg_match('/^(epon|gpon)\d+\/\d+:\d+/i', $line)) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            if (count($parts) < 6) {
                continue;
            }

            $interface = strtoupper($parts[0]);

            if ($this->olt_type === 'gpon') {

                $result[$interface] = [
                    'temperature' => (float)$parts[1],
                    'voltage'     => (float)$parts[2],
                    'bias_current'=> (float)$parts[3],
                    'rx_power'    => (float)$parts[4],
                    'tx_power'    => (float)$parts[5],
                ];

            } else {

                $result[$interface] = [
                    'temperature' => (float)$parts[1],
                    'voltage'     => (float)$parts[2],
                    'bias_current'=> (float)$parts[3],
                    'tx_power'    => (float)$parts[4],
                    'rx_power'    => (float)$parts[5],
                ];
            }
        }

        return $result;
    }
    private function parseVlan(string $output): ?string
    {
        if (
            preg_match(
                '/switchport\s+pvid\s+(\d+)/i',
                $output,
                $match
            )
        ) {
            return $match[1];
        }

        return null;
    }
    private function formate_mac_address($mac_address)
    {
        $get_mac_address = strtoupper(str_replace('.', '', $mac_address));

        return implode(':', str_split($get_mac_address, 2));
    }
}
