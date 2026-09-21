<?php
namespace App\Console\Commands\Tenants;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class TenantsRollback extends Command
{
    protected $signature = 'tenants:rollback {--step=1}';
    protected $description = 'Rollback migrations for all tenant databases';

    public function handle()
    {
        $tenants = DB::table('tenants')->get();

        foreach ($tenants as $tenant) {
            $this->info("Rolling back tenant: {$tenant->subdomain} ({$tenant->db_name})");

            /*------Build tenant connection-----*/
            $connection = [
                'driver'    => 'mysql',
                'host'      => env('DB_HOST', '127.0.0.1'),
                'port'      => env('DB_PORT', '3306'),
                'database'  => $tenant->db_name,
                'username'  => $tenant->db_user,
                'password'  => $tenant->db_pass,
                'charset'   => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix'    => '',
                'strict'    => true,
            ];

            /*------Register connection------*/
            Config::set("database.connections.tenant_{$tenant->id}", $connection);

            /*----Rollback----*/
            Artisan::call('migrate:rollback', [
                '--database' => "tenant_{$tenant->id}",
                '--step'     => $this->option('step'),
                '--force'    => true,
            ]);

            $this->line(Artisan::output());
        }

        $this->info("✅ All tenant rollbacks completed.");
    }
}
