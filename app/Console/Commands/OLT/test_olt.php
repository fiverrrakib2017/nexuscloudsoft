<?php

namespace App\Console\Commands\OLT;

use App\Models\Olt_device;
use App\Services\OLT\BdcomDriver;
use App\Services\OLT\FocuscomDriver;
use App\Services\OLT\VsolDriver;
use App\Services\OLT\TelnetClient;
use Illuminate\Console\Command;

class test_olt extends Command
{
    protected $signature = 'app:test_olt';

    protected $description = 'Test OLT Driver';

    public function handle()
    {
        $this->info(
            '-------Starting OLT Test-------'
        );

         try {

                // $focuscom_olt = new FocuscomDriver(
                //     '103.248.206.188',
                //     2222,
                //     'admin',
                //     'admin',
                //     'EPON'
                // );
                //$_onu_data = $focuscom_olt->getFullOnuData();

                $telnet = new TelnetClient(
                    '103.112.204.156',
                     4590,
                    'ITFAST',
                    'star@#321',
                );
                $telnet->connect()->login();
                $driver = new VsolDriver($telnet,'GPON','star@#321');



                // $telnet = new TelnetClient(
                //     '103.248.206.108',
                //     9003,
                //     'admin',
                //     'Xpon@Olt9417#',
                // );
                // $telnet->connect()->login();
                // $driver = new VsolDriver($telnet,'EPON','Xpon@Olt9417#');



                $_onu_data = $driver->getFullOnuData();
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
                        'Status',
                        'Offline Reason'
                    ],
                    $_onu_data
                );


            } catch (\Throwable $e) {

                $this->error(
                    $e->getMessage()
                );
            }
    }
}
