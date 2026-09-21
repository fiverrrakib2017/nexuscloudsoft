<?php
namespace App\Helpers;
class Telnet
{

    public static function connect($ip, $port = 23)
    {
        $fp = fsockopen($ip, $port, $errno, $errstr, 10);

        if (!$fp) {

            dd("Connection Failed", $errno, $errstr);

            return false;
        }

        stream_set_timeout($fp, 5);

        stream_set_blocking($fp, true);

        return $fp;
    }

    /*
    |--------------------------------------------------------------------------
    | READ BUFFER
    |--------------------------------------------------------------------------
    */

    public static function read($fp)
    {
        $output = '';

        $start = time();

        while (true) {

            $chunk = fread($fp, 4096);

            if ($chunk !== false) {
                $output .= $chunk;
            }

            /*
            |--------------------------------------------------------------------------
            | BREAK IF PROMPT FOUND
            |--------------------------------------------------------------------------
            */

            if (
                str_contains($output, 'Username') ||
                str_contains($output, 'Password') ||
                str_contains($output, '>') ||
                str_contains($output, '#') ||
                str_contains($output, '<EPON>')
            ) {
                break;
            }

            /*
            |--------------------------------------------------------------------------
            | TIMEOUT
            |--------------------------------------------------------------------------
            */

            if ((time() - $start) > 5) {
                break;
            }

            usleep(200000);
        }

        return trim($output);
    }

    /*
    |--------------------------------------------------------------------------
    | SEND COMMAND
    |--------------------------------------------------------------------------
    */

    public static function send($fp, $command)
    {
        fwrite($fp, $command . "\r\n");

        usleep(800000);

        $output = '';

        while (!feof($fp)) {

            $line = fgets($fp, 4096);

            if (!$line) {
                break;
            }

            $output .= $line;

            /*
            |--------------------------------------------------------------------------
            | AUTO ENTER FOR PAGINATION
            |--------------------------------------------------------------------------
            */

            if (
                str_contains($line, 'press ENTER') ||
                str_contains($line, 'next line')
            ) {

                fwrite($fp, "\r\n");

                usleep(500000);
            }

            /*
            |--------------------------------------------------------------------------
            | COMMAND END DETECT
            |--------------------------------------------------------------------------
            */

            if (
                str_contains($line, '#') ||
                str_contains($line, '>') ||
                str_contains($line, '<EPON>')
            ) {
                break;
            }
        }

        return $output;
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    public static function login($fp, $username, $password)
    {
        /*
        |--------------------------------------------------------------------------
        | WAIT USERNAME PROMPT
        |--------------------------------------------------------------------------
        */

        self::read($fp);

        /*
        |--------------------------------------------------------------------------
        | SEND USERNAME
        |--------------------------------------------------------------------------
        */

        fwrite($fp, $username . "\r\n");

        usleep(700000);

        self::read($fp);

        /*
        |--------------------------------------------------------------------------
        | SEND PASSWORD
        |--------------------------------------------------------------------------
        */

        fwrite($fp, $password . "\r\n");

        usleep(1000000);

        return self::read($fp);
    }
}
