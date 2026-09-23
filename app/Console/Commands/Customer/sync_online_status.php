<?php

namespace App\Console\Commands\Customer;

use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Router as Mikrotik_router;
use App\Services\RouterosAPI;
use Illuminate\Support\Facades\Schema;
use App\Models\Radius\Radacct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class sync_online_status extends Command
{
    /**
     * The name and signature of the console command.
     * Option: --pop_id= (Optional)
     * @var string
     */
    protected $signature = 'app:sync_online_status {--pop_id= : Specific POP ID to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync MikroTik and Radius active users in background for SaaS tenants';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $specific_pop_id = $this->option('pop_id');

        if ($specific_pop_id !== null) {
            $this->calculate_and_cache($specific_pop_id);
            return;
        }


        $pops = Customer::distinct()->pluck('pop_id')->filter()->toArray();

        foreach ($pops as $pop_id) {
            $this->calculate_and_cache($pop_id);
        }

        $this->calculate_and_cache(null);
    }

    private function calculate_and_cache($branch_user_id = null)
    {
        $_customer_status = Customer::where('is_delete', 0)
            ->when($branch_user_id, fn($q) => $q->where('pop_id', $branch_user_id))
            ->selectRaw("
                COUNT(*) as total_customer,
                SUM(CASE WHEN status='expired' THEN 1 ELSE 0 END) as expire_customer,
                SUM(CASE WHEN status='disabled' THEN 1 ELSE 0 END) as disable_customer,
                SUM(CASE WHEN status='discontinue' THEN 1 ELSE 0 END) as discontinue_customer,
                SUM(CASE WHEN status='active' THEN 1 ELSE 0 END) as active_customer,
                SUM(CASE WHEN amount=0 THEN 1 ELSE 0 END) as free_customer
            ")
            ->first();

        $active_customer = (int) ($_customer_status->active_customer ?? 0);
        $all_online_usernames = [];

        if (Schema::hasTable('radacct')) {
            try {
                $radiusUsers = Radacct::whereNull('acctstoptime')
                    ->pluck('username')
                    ->map(fn($u) => trim($u))
                    ->toArray();
                $all_online_usernames = array_merge($all_online_usernames, $radiusUsers);
            } catch (\Exception $e) {
                Log::warning("Radius Query Failed: " . $e->getMessage());
            }
        }

        /*--------MikroTik Active Users------*/
        $routers = Mikrotik_router::where('status', 'active')
            ->when($branch_user_id, fn($q) => $q->where('pop_id', $branch_user_id))
            ->get(['ip_address', 'username', 'password', 'port']);

        foreach ($routers as $routerInfo) {
            try {
                $API = new RouterosAPI();
                $API->debug = false;
                $API->timeout = 2;

                if ($API->connect($routerInfo->ip_address, $routerInfo->username, $routerInfo->password, (int)($routerInfo->port ?? 8728))) {
                    $rawActive = $API->comm('/ppp/active/print');
                    if (is_array($rawActive)) {
                        foreach ($rawActive as $row) {
                            if (!empty($row['name'])) {
                                $all_online_usernames[] = trim($row['name']);
                            }
                        }
                    }
                    $API->disconnect();
                }
            } catch (\Exception $e) {
                Log::warning("MikroTik Connection Failed IP [{$routerInfo->ip_address}]: " . $e->getMessage());
            }
        }

        $unique_online_usernames = array_unique($all_online_usernames);

        /*--------Count Online Customer ----------*/
        $online_customer = 0;
        if ($active_customer > 0 && !empty($unique_online_usernames)) {
            $online_customer = Customer::where('is_delete', 0)
                ->where('status', 'active')
                ->when($branch_user_id, fn($q) => $q->where('pop_id', $branch_user_id))
                ->whereIn('username', $unique_online_usernames)
                ->count();
        }

        $offline_customer = max(0, $active_customer - $online_customer);

        $target_pop_id = $branch_user_id ?? 0;

        DB::table('dashboard_summaries')->updateOrInsert(
            ['pop_id' => $target_pop_id],
            [
                'online'      => $online_customer,
                'offline'     => $offline_customer,
                'active'      => $active_customer,
                'expired'     => (int) ($_customer_status->expire_customer ?? 0),
                'disabled'    => (int) ($_customer_status->disable_customer ?? 0),
                'discontinue' => (int) ($_customer_status->discontinue_customer ?? 0),
                'free'        => (int) ($_customer_status->free_customer ?? 0),
                'total'       => (int) ($_customer_status->total_customer ?? 0),
                'updated_at'  => now()
            ]
        );
    }
}
