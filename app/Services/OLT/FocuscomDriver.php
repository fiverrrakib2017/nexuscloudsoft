<?php

namespace App\Services\OLT;

class FocuscomDriver
{
    protected $socket;

    protected string $ip_address;
    protected int $port;
    protected string $username;
    protected string $password;
    protected string $olt_type;

    protected array $commands = [

        'onu_info'      => 'display onu info',

        'offline_onu'   => 'display onu offline',

        'optical'       => 'display onu opm all',

        'mac_table'     => 'display mac-address-table onu',

        'vlan'          => 'display vlan',

        'distance'      => 'display epon',

    ];

    public function __construct(string $ip_address,int $port,string $username,string $password,string $oltType = 'EPON') {
        $this->ip_address = $ip_address;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->olt_type = strtolower($oltType);

        $this->connect();

        $this->login();

        $this->boot();
    }
    protected function boot(): void
    {
        $this->executeCommand('enable');

    }
    public function executeCommand(string $command, int $idleTimeout = 10): string
    {
        $this->flushSocket();

        fwrite($this->socket, $command . "\r\n");

        $buffer = '';

        $lastDataTime = microtime(true);

        while (true) {

            $data = fread($this->socket, 8192);

            if ($data !== false && $data !== '') {

                $buffer .= $data;

                $lastDataTime = microtime(true);

                if ( stripos($buffer, 'press ENTER to next line') !== false) {

                    fwrite($this->socket, "\r\n");

                    $buffer = str_replace(
                        '....press ENTER to next line, CTRL_C to break, other key to next page....',
                        '',
                        $buffer
                    );
                }
            }

            if ((microtime(true) - $lastDataTime)> $idleTimeout) {
                break;
            }

            usleep(10000);
        }

        return trim($buffer);
    }
    private function flushSocket(): void
    {
        stream_set_blocking($this->socket, false);

        while (true) {

            $data = fread($this->socket, 8192);

            if ($data === false || $data === '') {
                break;
            }
        }

        stream_set_blocking($this->socket, true);
    }
    public function connect(){
        /*------Check The Connection--------*/
        if($this->check_connection()){
            return $this;
        }
        /*-------Connection----------*/
        $this->socket = fsockopen(
            $this->ip_address,
            $this->port,
            $errno,
            $errstr,
            10
        );
        /*-------IF Connection Fails----------*/
        if (! $this->socket) {
            throw new \Exception("Connection failed: {$errstr}");
        }
        stream_set_timeout($this->socket,10);

        return $this;
    }
    public function check_connection(): bool
    {
        return is_resource($this->socket);
    }
    public function login(){
         stream_set_timeout($this->socket,10);

        $this->negotiateTelnet();
        $this->readUntilAny([
            'Username:',
            'username:',
            'login:',
            'Login:'
        ]);


        fwrite($this->socket, $this->username . "\r\n");

         $this->readUntilAny([
            'Password:',
            'password:'
        ]);


        fwrite($this->socket, $this->password . "\r\n");

       $this->readUntilAny([
            '>',
            '#',
            '<EPON>'
        ], 15);


        return $this;
    }
    private function negotiateTelnet(): void
    {
        stream_set_blocking($this->socket, false);

        $start = microtime(true);

        while ((microtime(true) - $start) < 2) {

            $data = fread($this->socket, 4096);

            if ($data === false || $data === '') {
                usleep(100000);
                continue;
            }

            $len = strlen($data);

            for ($i = 0; $i < $len; $i++) {

                $byte = ord($data[$i]);

                if ($byte === 255 && isset($data[$i + 2])) {

                    $cmd = ord($data[$i + 1]);
                    $opt = ord($data[$i + 2]);

                    if ($cmd === 251 || $cmd === 252) {

                        fwrite(
                            $this->socket,
                            chr(255) . chr(254) . chr($opt)
                        );

                    } elseif ($cmd === 253 || $cmd === 254) {

                        fwrite(
                            $this->socket,
                            chr(255) . chr(252) . chr($opt)
                        );
                    }

                    $i += 2;
                }
            }
        }

        stream_set_blocking($this->socket, true);
    }

    protected function command(string $key): string
    {
        if (!isset($this->commands[$key])) {

            throw new \Exception("Command {$key} not found.");
        }

        return $this->commands[$key];
    }
    protected  function readUntil($prompt, $timeout = 10)
    {
        return $this->readUntilAny([$prompt], $timeout);
    }

    protected  function readUntilAny(array $prompts, $timeout = 10)
    {
        $buffer = '';
        $start = time();

        while ((time() - $start) < $timeout) {
            $data = fread($this->socket, 4096);

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

    public function __destruct()
    {
        $this->close();
    }
    public function close(): void
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
        }
    }
    public function getFullOnuData(): array
    {

        $onuInfo        = $this->getOnuInformation();
        //$offline        = $this->getOfflineOnu();
        $distanceTable  = $this->get_distance_table();

        $optical        = $this->getOpticalPower();

        $macTable       = $this->getMacTable();

        $vlanTable      = $this->getVlanTable();

        $result = [];

        foreach ($onuInfo as $interface => $onu) {

            preg_match('/^(\d+\/\d+\/\d+):\d+$/', $interface,$match);

            $ponPort = isset($match[1])? 'EPON' . $match[1]: null;

            $vlan = $ponPort? ($vlanTable[$ponPort] ?? null): null;
            // dd([
            //     'interface' => $interface,
            //     'ponPort' => $ponPort,
            //     'mac_exists' => isset($macTable[$interface]),
            //     'mac_sample' => $macTable[$interface] ?? null,
            //     'vlan_exists' => isset($vlanTable[$ponPort]),
            //     'vlan_sample' => $vlanTable[$ponPort] ?? null,
            // ]);
            $result[] = [

                $onu['index_id'] ?? null,

                $interface,

                $macTable[$interface]['mac'] ?? null,

                'null',

                $vlan,

                $distanceTable[$interface]['distance'] ?? null,

                $optical[$interface]['rx_power'] ?? '0',

                $optical[$interface]['tx_power']?? '0',

                $optical[$interface]['temperature'] ?? '0',

                $optical[$interface]['voltage'] ?? '0',

                strtolower($onu['status']) === 'normal' ? 'online': 'offline',

                //$offline[$interface]['offline_reason'] ?? null,
            ];
        }

        return $result;
    }
    public function getSingleOnuSignal(string $interface)
    {

        try {

            $opticalTable = $this->getOpticalPower();

            $onuTable = $this->getOnuInformation();

            $optical = $opticalTable[$interface] ?? [];


            $status = $onuTable[$interface]['status'] ?? 'offline';

            return [

                'success'     => true,

                'rx_power'    => $optical['rx_power'] ?? null,

                'tx_power'    => $optical['tx_power'] ?? null,


                'status'      => strtolower($status) === 'normal'? 'online': 'offline',
            ];

        } catch (\Throwable $e) {

            return [

                'success' => false,

                'error_message' => $e->getMessage(),
            ];
        }
    }
    public function getOnuInformation(): array
    {
        $output = $this->executeCommand($this->command('onu_info'));
        return $this->parseOnuInformation($output);
    }
    private function parseOnuInformation(string $output): array
    {
        $result = [];

        /*---------ANSI escape remove------*/
        $output = preg_replace(
            '/\x1B\[[0-9;]*[A-Za-z]/',
            '',
            $output
        );

        /*----------NULL byte remove------*/
        $output = str_replace("\0", '', $output);

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $index => $line) {

            $line = trim($line);

            if (!preg_match('/^(\d+\/\d+\/\d+:\d+)\s+([0-9a-f:]{17})/i', $line,$match)) {
                continue;
            }

            $interface = $match[1];

            $status = 'offline';

            if (isset($lines[$index + 1])) {

                $nextLine = trim($lines[$index + 1]);

                if (stripos($nextLine, 'Normal') !== false) {
                    $status = 'Normal';
                }
            }
            preg_match('/:(\d+)$/',$interface,$idMatch);

            $onuId = (int)($idMatch[1] ?? 0);

            $result[$interface] = [
                'index_id'  => $onuId,

                'interface' => $interface,

                'status' => $status,
            ];
        }

        return $result;
    }
    public function getOfflineOnu(): array
    {
        $output = $this->executeCommand($this->command('offline_onu'));

        return $this->parseOfflineOnu($output);
    }
    private function parseOfflineOnu(string $output): array {

        $result = [];

        $lines = preg_split("/\r?\n/",$output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (!preg_match('/^(\d+\/\d+\/\d+:\d+)/',$line,$match)) {
                continue;
            }

            $parts = preg_split('/\s+/',$line);

            $result[$match[1]] = [
                'offline_reason' =>end($parts),
            ];
        }

        return $result;
    }

    public function getOpticalPower(): array
    {
        $output = $this->executeCommand($this->command('optical'),70);
        return $this->parseOpticalPower($output);
    }
    private function parseOpticalPower(string $output): array
    {
        $result = [];

        /*-------ANSI escape code remove----*/
        $output = preg_replace(
            '/\x1B\[[0-9;]*[A-Za-z]/',
            '',
            $output
        );

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (
                !preg_match(
                    '/(\d+\/\d+\/\d+:\d+)/',
                    $line,
                    $match
                )
            ) {
                continue;
            }

            $parts = preg_split('/\s+/', $line);

            if (count($parts) < 6) {
                continue;
            }

            preg_match(
                '/\/(-?\d+\.?\d*)$/',
                $parts[4],
                $tx
            );

            preg_match(
                '/\/(-?\d+\.?\d*)$/',
                $parts[5],
                $rx
            );

            $interface = $match[1];

            $result[$interface] = [

                'temperature'  => (float) $parts[1],

                'voltage'      => (float) $parts[2],

                'bias_current' => (float) $parts[3],

                'tx_power'     => (float) ($tx[1] ?? 0),

                'rx_power'     => (float) ($rx[1] ?? 0),
            ];
        }

        return $result;
    }
    public function get_distance_table(): array{
        $output = $this->executeCommand($this->command('distance'));

        return $this->parseDistanceTable($output);
    }
    private function parseDistanceTable(string $output): array {
        $result = [];

        $output = preg_replace( '/\x1B\[[0-9;]*[A-Za-z]/', '',$output);

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (!preg_match( '/(\d+\/\d+\/\d+:\d+)\s+[0-9a-f:]{17}\s+\S+\s+(\d+)/i',
                    $line, $match)) {
                continue;
            }

            $result[$match[1]] = [

                'distance' => (int) $match[2],
            ];
        }

        return $result;
    }
    public function getMacTable(): array
    {
        $output = $this->executeCommand($this->command('mac_table'),100);
        return $this->parseOnuMacTable($output);
    }
    private function parseOnuMacTable(string $output): array
    {
        $result = [];

        $output = preg_replace(
            '/\x1B\[[0-9;]*[A-Za-z]/',
            '',
            $output
        );

        $output = str_replace("\0", '', $output);

        $lines = preg_split("/\r?\n/", $output);

        foreach ($lines as $line) {

            $line = trim($line);

            if (
                preg_match(
                    '/^(\d+\/\d+\/\d+:\d+)\s+([0-9a-f:]{17})\s+(\d+)/i',
                    $line,
                    $match
                )
            ) {

                if (!isset($result[$match[1]])) {

                    $result[$match[1]] = [

                        'interface' => $match[1],

                        'mac' => strtoupper($match[2]),

                        'vlan' => (int)$match[3],
                    ];
                }
            }
        }

        return $result;
    }

    public function getVlanTable(): array
    {
        $output = $this->executeCommand( $this->command('vlan'),15);
        return $this->parseVlanTable($output);
    }
    private function parseVlanTable(string $output): array
    {
        $result = [];

        $blocks = preg_split('/display VLAN information/i',$output);

        foreach ($blocks as $block) {

            if (!preg_match('/VLAN ID\s*:\s*(\d+)/i',$block,$vlanMatch)) {
                continue;
            }

            $vlan = (int)$vlanMatch[1];

            if (preg_match('/epon(\d+\/\d+\/\d+)\./i',$block,$portMatch)) {
                $result[
                    'EPON' . $portMatch[1]
                ] = $vlan;
            }
        }

        return $result;
    }

}
