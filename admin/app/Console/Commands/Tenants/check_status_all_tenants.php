<?php

namespace App\Console\Commands\Tenants;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Command;

class check_status_all_tenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check_status_all_tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run customer status check for all tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lock = cache()->lock('status_all_tenants_lock', 300);

        if (!$lock->get()) {

            $this->info('Status sync already running...');

            return;
        }

        try {

            $tenants = DB::connection('mysql')
                    ->table('tenants')
                    ->where('status',1)
                    ->get();

            foreach ($tenants as $tenant) {

                try {

                    $this->info("Running status check for: {$tenant->db_name}");

                    Log::info('Manual Status Sync Started', [
                        'tenant' => $tenant->db_name
                    ]);

                    $this->__set_tenant_connection($tenant);

                    Artisan::call('app:check_status');

                    $this->info(Artisan::output());

                    Log::info('Manual Status Sync Finished', [
                        'tenant' => $tenant->db_name
                    ]);

                } catch (\Throwable $e) {

                    Log::error('Tenant Status Sync Failed', [
                        'tenant' => $tenant->db_name,
                        'message' => $e->getMessage()
                    ]);

                    continue;
                }
            }

            $this->info('All tenant status checks completed.');

        } finally {

            optional($lock)->release();
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
