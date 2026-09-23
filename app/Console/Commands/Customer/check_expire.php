<?php

namespace App\Console\Commands\Customer;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\Customer;
use App\Models\Grace_recharge;
use App\Models\Router;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\SessionService;
use App\Services\RouterosAPI;

class check_expire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check_expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer Check Expire';

    /**
     * Execute the console command.
     */
    public function handle(SessionService $session_service)
    {
        $this->info('---Tasks Started ---');
        $today = Carbon::now()->format('Y-m-d');
        /*-------Process function---------*/
        $this->process_grace_recharge($today);
        $this->process_radius_customer($today);
        $this->process_mikrotik_customer($today);
        $this->info('---Tasks Finished ---');
    }
    protected function process_grace_recharge(string $today){
        $this->info('Processing Grace Recharges...');
        Grace_recharge::with('customer')->chunkById(500, function ($graceList) use ($today) {
            foreach ($graceList as $grace) {
                if ($grace->customer && $grace->customer->expire_date <= $today) {
                    $new_expire_date = Carbon::parse($grace->customer->expire_date)->subDays($grace->days);

                    $grace->customer->update([
                        'expire_date' => $new_expire_date
                    ]);

                    $grace->delete();
                }
            }
        });
    }
    protected function process_radius_customer(string $today){
        $this->info('Processing RADIUS Expire Customers...');
        Customer::where('is_delete', '0')
            ->where('connection_type', 'radius')
            ->where('expire_date', '<=', $today)
            ->whereIn('status', ['active', 'online', 'offline'])
            ->chunkById(1000, function ($customers) {

                $usernames = $customers->pluck('username')->toArray();
                $customerIds = $customers->pluck('id')->toArray();

                if (!empty($usernames)) {
                    /*----------Bulk Delete on Radius Tables------*/
                    \App\Models\Radius\Radcheck::whereIn('username', $usernames)->delete();
                    \App\Models\Radius\Radreply::whereIn('username', $usernames)->delete();

                    /*-----Update Customer Status----------*/
                    Customer::whereIn('id', $customerIds)->update(['status' => 'expired']);
                }
            });
    }
    protected function process_mikrotik_customer(string $today){
        $this->info('Processing PPPoE Expire Customers...');
        $active_routers = Router::where('status', 'active')->get();
        foreach($active_routers as $router){
            $expire_customers = Customer::where('is_delete', '0')
                ->where('connection_type', 'pppoe')
                ->where('router_id', $router->id)
                ->where('expire_date', '<=', $today)
                ->whereIn('status', ['active', 'online', 'offline'])
                ->get(['id', 'username']);

                if ($expire_customers->isEmpty()) {
                    continue;
                }

            $this->info("Connecting to Router: {$router->ip_address} for " . $expire_customers->count() . " users.");

            /*-------Connect Mikrotik Router-------*/
            $API = new RouterosAPI();
            $API->timeout = 5;
            $API->attempts = 1;
            if ($API->connect($router->ip_address, $router->username, $router->password, (int)$router->port)) {

                $raw_secrets = $API->comm('/ppp/secret/print');
                $raw_active  = $API->comm('/ppp/active/print');

                $ppp_secrets  = collect(is_array($raw_secrets) ? $raw_secrets : [])->keyBy('name');
                $active_users = collect(is_array($raw_active) ? $raw_active : [])->groupBy('name');

                $expired_ids = [];

                foreach ($expire_customers as $customer) {
                    $username = $customer->username;

                    if ($ppp_secrets->has($username)) {
                        $secret = $ppp_secrets->get($username);

                        if ($active_users->has($username)) {
                            foreach ($active_users->get($username) as $active_session) {
                                $API->comm('/ppp/active/remove', [
                                    '.id' => $active_session['.id']
                                ]);
                            }
                        }

                        /*----------Secret Disable-----*/
                        $API->comm('/ppp/secret/set', [
                            '.id'      => $secret['.id'],
                            'disabled' => 'yes'
                        ]);

                        $expired_ids[] = $customer->id;
                    } else {
                        Log::warning("PPP secret not found on router [{$router->ip_address}] for user: {$username}");
                    }
                }

                if (!empty($expired_ids)) {
                    Customer::whereIn('id', $expired_ids)->update(['status' => 'expired']);
                }

                $API->disconnect();
            } else {
                Log::error("Failed to connect to Router IP: {$router->ip_address}");
            }
        }
    }
    // protected function check_expire_customer()
    // {
    //     $today = Carbon::now()->format('Y-m-d');

    //     $expire_customers = Customer::where('is_delete', '0')
    //         ->where('expire_date', '<=', $today)
    //         //->where('username','Sahin@poduia')
    //         ->whereIn('status', ['active', 'online', 'offline'])
    //         ->get();
    //     foreach ($expire_customers as $customer) {
    //         if ($customer->connection_type == 'pppoe') {

    //             /*------- Remove Grace Recharge For this Customer ------------*/
    //             $get_grace_recharge = Grace_recharge::where('customer_id', $customer->id)->first();
    //             if ($get_grace_recharge) {

    //                 if ($customer->expire_date) {

    //                     $customer->expire_date = \Carbon\Carbon::parse($customer->expire_date)
    //                         ->subDays($get_grace_recharge->days);

    //                     $customer->save();
    //                 }

    //                 $get_grace_recharge->delete();
    //             }

    //             /*--------- Find Mikrotik Router For this Customer--------*/
    //             $router = Router::where('status', 'active')->where('id', $customer->router_id)->first();
    //             if (!$router) {
    //                 continue;
    //             }

    //            try {

    //                 $API = new RouterosAPI();
    //                 $API->timeout = 10;
    //                 $API->attempts = 1;

    //                 if ($API->connect(
    //                     $router->ip_address,
    //                     $router->username,
    //                     $router->password,
    //                     (int) $router->port
    //                 )) {

    //                     /* PPP Secret List */
    //                     $rawSecrets = $API->comm('/ppp/secret/print');

    //                     $pppSecrets = collect(
    //                         is_array($rawSecrets) ? $rawSecrets : []
    //                     )->keyBy('name');

    //                     if ($pppSecrets->has($customer->username)) {

    //                         $secret = $pppSecrets->get($customer->username);

    //                         /* Active User List */
    //                         $rawActive = $API->comm('/ppp/active/print');

    //                         $activeUsers = collect(
    //                             is_array($rawActive) ? $rawActive : []
    //                         )->where('name', $customer->username);

    //                         /* Remove Active Session */
    //                         foreach ($activeUsers as $activeUser) {

    //                             $API->comm('/ppp/active/remove', [
    //                                 '.id' => $activeUser['.id']
    //                             ]);
    //                         }

    //                         /* Disable PPP Secret */
    //                         $API->comm('/ppp/secret/set', [
    //                             '.id'      => $secret['.id'],
    //                             'disabled' => 'yes'
    //                         ]);

    //                         /*--------- Update Customer Status ---------*/
    //                         $customer->update([
    //                             'status' => 'expired'
    //                         ]);
    //                     } else {
    //                         $this->warn("PPP secret not found for {$customer->username}");
    //                     }

    //                     $API->disconnect();

    //                 } else {

    //                     $this->error("Router connection failed for {$customer->username}");
    //                 }

    //             } catch (\Exception $e) {

    //                 $this->error(
    //                     "Error for {$customer->username}: ".$e->getMessage()
    //                 );
    //             }
    //         }
    //         if ($customer->connection_type == 'radius') {
    //             \App\Models\Radius\Radcheck::where('username', $customer->username)->delete();
    //             \App\Models\Radius\Radreply::where('username', $customer->username)->delete();

    //             $this->info("Radius user {$customer->username} access removed.");
    //             /*-------- Now update DB---------*/
    //             $customer->update(['status' => 'expired']);
    //             $this->info("Customer {$customer->username} is (Expired)");
    //         }
    //         if ($customer->connection_type == 'hotspot') {

    //         }
    //     }
    // }
}
