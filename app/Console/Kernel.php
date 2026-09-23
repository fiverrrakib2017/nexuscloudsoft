<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $tenants = DB::connection('mysql')
                    ->table('tenants')
                    ->where('status', 1)
                    ->get();

        foreach ($tenants as $tenant) {

            /*------Sync Online Customer Status -------*/
            // $schedule
            //     ->call(function () use ($tenant) {
            //         $this->__set_tenant_connection($tenant);
            //         Artisan::call('app:sync_online_status');
            //     })
            //     ->everyTwoMinutes();

            /*------Customer Expire Cron job Start--------*/
            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:check_expire');
                })
                ->dailyAt('12:00');

            /*------Customer Usages Cron job Start--------*/
            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:customer_usage');
                })
                ->everyFiveMinutes();

            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:weekly_usage_rollup');
                })
                ->weeklyOn(1, '03:00');

            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:clean_daily_usages');
                })
                ->monthlyOn(1, '01:00');

            /*------Auto Message--------*/
            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:send_auto_message');
                })
                ->dailyAt('10:05');

            /*------Monthly Bill Target--------*/
            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:monthly_bill_target');
                })
                ->monthlyOn(1, '00:00');

            /*------Sync OLT Onu Data--------*/
            $schedule
                ->call(function () use ($tenant) {
                    $this->__set_tenant_connection($tenant);
                    Artisan::call('app:sync_onu_data');
                })
                ->twiceDaily(8, 18);
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

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
