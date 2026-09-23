<?php

namespace App\Console\Commands\Tenants;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class check_expire_all_tenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check_expire_all_tenants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run expire command for all tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = DB::connection('mysql')
            ->table('tenants')
            ->where('status',1)
            ->get();

        foreach ($tenants as $tenant) {

            $this->info("Running for: {$tenant->db_name}");

            $this->__set_tenant_connection($tenant);

            Artisan::call('app:check_expire');

            $this->info(Artisan::output());
        }

        $this->info('All tenant expire checks completed.');
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
