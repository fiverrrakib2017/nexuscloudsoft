<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Router;
use App\Models\Radius\Radacct;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\RouterosAPI;

class CustomerStatusService
{
    protected array $dashboard = [];
    protected array $pop = [];

    protected array $online_usernames = [];
    protected array $radius_users = [];

    protected ?int $branch_user_id = null;
    protected bool $loaded = false;

    public function build()
    {
        if ($this->loaded) {
            return $this;
        }

        $this->branch_user_id = Auth::guard('admin')->user()->pop_id ?? null;

        $this->load_mikrotik_active_users();
        $this->load_radius_active_users();
        $this->process_all_stats();

        $this->loaded = true;
        return $this;
    }

    protected function load_mikrotik_active_users()
    {
        $routers = Router::when($this->branch_user_id, function($q) {
            return $q->where('pop_id', $this->branch_user_id);
        })->get(['ip_address', 'username', 'password', 'port']);

        foreach ($routers as $routerInfo) {
            try {
                $API = new RouterosAPI();
                $API->debug = false;
                $API->timeout = 2; 

                if ($API->connect(
                    $routerInfo->ip_address,
                    $routerInfo->username,
                    $routerInfo->password,
                    (int) ($routerInfo->port ?? 8728)
                )) {
                    $rawActive = $API->comm('/ppp/active/print');

                    if (is_array($rawActive)) {
                        foreach ($rawActive as $row) {
                            if (!empty($row['name'])) {
                                $cleanName = strtolower(trim($row['name']));
                                $this->online_usernames[$cleanName] = true;
                            }
                        }
                    }
                    $API->disconnect();
                }
            } catch (\Exception $e) {
                Log::warning("MikroTik Connection Failed for Router IP [{$routerInfo->ip_address}]: " . $e->getMessage());
            }
        }
    }

    protected function load_radius_active_users()
    {
        if (Schema::hasTable('radacct')) {
            try {
                $this->radius_users = Radacct::whereNull('acctstoptime')
                    ->distinct()
                    ->pluck('username')
                    ->map(fn($u) => strtolower(trim($u)))
                    ->flip()
                    ->toArray();
            } catch (\Exception $e) {
                Log::warning("Radius Query Failed: " . $e->getMessage());
            }
        }
    }

    protected function process_all_stats()
    {
        $_customer_status = Customer::where('is_delete', 0)
            ->when($this->branch_user_id, fn($q) => $q->where('pop_id', $this->branch_user_id))
            ->selectRaw("
                COUNT(*) as total_customer,
                SUM(CASE WHEN status='expired' THEN 1 ELSE 0 END) as expire_customer,
                SUM(CASE WHEN status='disabled' THEN 1 ELSE 0 END) as disable_customer,
                SUM(CASE WHEN status='discontinue' THEN 1 ELSE 0 END) as discontinue_customer,
                SUM(CASE WHEN status='active' THEN 1 ELSE 0 END) as active_customer,
                SUM(CASE WHEN amount=0 THEN 1 ELSE 0 END) as free_customer
            ")
            ->first();

        $this->dashboard = [
            'total'       => (int) ($_customer_status->total_customer ?? 0),
            'active'      => (int) ($_customer_status->active_customer ?? 0),
            'expired'     => (int) ($_customer_status->expire_customer ?? 0),
            'disabled'    => (int) ($_customer_status->disable_customer ?? 0),
            'discontinue' => (int) ($_customer_status->discontinue_customer ?? 0),
            'free'        => (int) ($_customer_status->free_customer ?? 0),
            'online'      => 0,
            'offline'     => 0,
        ];

        $customers = Customer::where('is_delete', 0)
            ->when($this->branch_user_id, fn($q) => $q->where('pop_id', $this->branch_user_id))
            ->select(['id', 'username', 'status', 'connection_type', 'amount', 'pop_id'])
            ->get();

        foreach ($customers as $customer) {
            $popId = $customer->pop_id ?? 0;

            if (!isset($this->pop[$popId])) {
                $this->pop[$popId] = $this->get_default_structure();
            }

            $this->pop[$popId]['total']++;

            if ($customer->amount == 0) {
                $this->pop[$popId]['free']++;
            }
            if (in_array($customer->status, ['active', 'expired', 'disabled', 'discontinue'])) {
                $this->pop[$popId][$customer->status]++;
            }

            $isOnline = false;
            if ($customer->status === 'active') {
                $cleanUsername = strtolower(trim($customer->username));

                if ($customer->connection_type === 'pppoe' && !empty($this->online_usernames)) {
                    $isOnline = isset($this->online_usernames[$cleanUsername]);
                }

                if ($customer->connection_type === 'radius' && !empty($this->radius_users)) {
                    $isOnline = isset($this->radius_users[$cleanUsername]);
                }
            }

            if ($isOnline) {
                $this->dashboard['online']++;
                $this->pop[$popId]['online']++;
            } else {
                if ($customer->status === 'active') {
                    $this->dashboard['offline']++;
                    $this->pop[$popId]['offline']++;
                }
            }
        }
    }

    protected function get_default_structure(): array
    {
        return [
            'total'       => 0,
            'active'      => 0,
            'expired'     => 0,
            'disabled'    => 0,
            'discontinue' => 0,
            'free'        => 0,
            'online'      => 0,
            'offline'     => 0,
        ];
    }

    public function dashboard(): array
    {
        return $this->dashboard;
    }

    public function pop(?int $pop_id = null): array
    {
        if ($pop_id === null) {
            return $this->pop;
        }

        return $this->pop[$pop_id] ?? $this->get_default_structure();
    }
}
