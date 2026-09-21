<?php
namespace App\Services\OLT;

class TelnetClient {
    protected $socket;

    protected string $ip_address;
    protected int $port;
    protected string $username;
    protected string $password;

    public function __construct( string $ip_address,int $port,string $username,string $password)
    {
        $this->ip_address       = $ip_address;
        $this->port             = $port;
        $this->username         = $username;
        $this->password         = $password;
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
            throw new \Exception(
                "Connection failed: {$errstr}"
            );
        }
        stream_set_timeout(
            $this->socket,
            10
        );

        return $this;
    }
    public function check_connection(): bool
    {
        return is_resource($this->socket);
    }
    public function login(){
        $this->readUntil('Username:');
        fwrite($this->socket, $this->username . "\r\n");

        $this->readUntil('Password:');
        fwrite($this->socket, $this->password . "\r\n");

        $this->readUntilAny( ['>', '#']);
        return $this;
    }
    public function executeCommand(string $command, int $timeout = 10): string
    {
        if (!is_resource($this->socket)) {
            throw new \Exception(
                'Telnet connection not established.'
            );
        }

        fwrite($this->socket, $command . "\r\n");

        $buffer = '';
        $startTime = microtime(true);

        while ((microtime(true) - $startTime) < $timeout) {

            $data = fread($this->socket, 8192);

            if ($data !== false && $data !== '') {

                $buffer .= $data;

                // Prompt detected
                if (preg_match('/[\r\n].+[>#]\s*$/m', $buffer)) {
                    break;
                }
            }

            usleep(20000); // 20ms
        }

        return trim($buffer);
    }
    public function executeCommand_old(string $command,  int $timeout = 2):string
    {

        if (! is_resource($this->socket)) {
            throw new \Exception(
                'Telnet connection not established.'
            );
        }
        fwrite($this->socket, $command . "\r\n");

        $buffer = '';
        $lastDataTime = microtime(true);

        while (true) {
            $data = fread($this->socket, 8192);

            if ($data !== false && $data !== '') {
                $buffer .= $data;
                $lastDataTime = microtime(true);
            }

            /*--------Stop after 2 seconds without new data.------*/
            if ((microtime(true) - $lastDataTime) >= $timeout) {
                break;
            }

            usleep(100000);
        }

        return trim($buffer);
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

}
