<?php

namespace App\Console\Commands\Tenants;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;

class sync_olt_all_tenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync_olt_all_tenants';


    public function handle()
    {
        try {

            $tenants = DB::connection('mysql')
                    ->table('tenants')
                    ->where('status',1)
                    ->get();

            foreach ($tenants as $tenant) {

                try {

                    $this->info("Running Sync Olt Data From: {$tenant->db_name}");

                    $this->__set_tenant_connection($tenant);

                    Artisan::call('app:sync_onu_data');

                    $this->info(Artisan::output());



                } catch (\Throwable $e) {

                    Log::error('Tenant OLT Sync Failed', [
                        'tenant' => $tenant->db_name,
                        'message' => $e->getMessage()
                    ]);

                    continue;
                }
            }

            $this->info('All tenant OLT Sync completed.');

        } finally {


        }
    }
    private function __set_tenant_connection($tenant)
    {
        Config::set('database.connections.tenant', [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'port'     => env('DB_PORT', '3306'),
            'database' => $tenant->db_name,
            'username' => $tenant->db_user,
            'password' => $tenant->db_pass,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
        DB::setDefaultConnection('tenant');
    }
}
