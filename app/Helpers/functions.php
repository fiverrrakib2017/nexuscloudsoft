<?php
namespace App\Helpers;

use App\Models\Branch_transaction;
use App\Models\Customer;
use App\Models\Branch_package;
use App\Models\Customer_log;
use App\Models\Sms_configuration;
use App\Models\Customer_recharge;
use App\Models\Grace_recharge;
use App\Models\Pop_branch;
use App\Models\Day_recharge;
use App\Models\Router as Mikrotik_router;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\Radius\Radcheck;
use Illuminate\Support\Facades\DB;
use App\Services\OLT\BdcomDriver;
use App\Services\OLT\VsolDriver;
use App\Services\OLT\FocuscomDriver;
use App\Services\OLT\TelnetClient;
use App\Services\RouterosAPI;
use App\Models\Radius\Radacct;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

if (!function_exists('check_pop_balance')) {
    function check_pop_balance(int $pop_id)
    {

        $transaction = Branch_transaction::where('pop_id', $pop_id)
            ->selectRaw("
                SUM(CASE WHEN transaction_type NOT IN ('due_paid', 'return') THEN amount ELSE 0 END) as main_balance,
                SUM(CASE WHEN transaction_type = 'return' THEN amount ELSE 0 END) as returned_balance
            ")
            ->first();

        $main_balance     = $transaction->main_balance ?? 0;
        $returned_balance = $transaction->returned_balance ?? 0;

        $total_balance = $main_balance - $returned_balance;

        $_customer_recharge = Customer_recharge::where('pop_id', $pop_id)
            ->where('transaction_type', '!=', 'due_paid')
            ->sum('purchase_price');

        $total_day_wise_recharge = Day_recharge::where('pop_id', $pop_id)
            ->sum('total_amount');

        $total_customer_recharge = $_customer_recharge + $total_day_wise_recharge;

        $own_balance = $total_balance - $total_customer_recharge;

        $child_ids = Pop_branch::where('parent_id', $pop_id)->pluck('id')->toArray();

        $children_total = 0;
        foreach ($child_ids as $child_id) {
            if ($child_id == $pop_id) continue;

            $children_total += check_pop_balance($child_id);
        }

        $net = $own_balance - $children_total;

        $memo[$pop_id] = $net;
        return $net ?? 0;
    }
}
/*---------------Inoivce No Auto Generate ----------------*/
if(!function_exists('generate_invoice_number')){
    function generate_invoice_number(){
        $random_number=rand();
        return 'INV-' . date('Y') . '-' . str_pad($random_number + 1, 6, '0', STR_PAD_LEFT);
    }
}
if (!function_exists('current_month_days')) {
    function current_month_days()
    {
         $current_month = date('m');
        $current_year = date('Y');
        return cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
    }
}
if (!function_exists('fetch_customer_data')) {
    function fetch_customer_data(Request $request, $isDeleteCondition)
    {
        $search = $request->search['value'] ?? '';
        $columnsForOrderBy = ['id', 'id', 'fullname', 'package', 'amount', 'created_at', 'expire_date', 'username', 'phone', 'pop_id', 'area_id', 'created_at', 'created_at'];

        $orderByColumn = $request->order[0]['column'] ?? 0;
        $orderDirection = $request->order[0]['dir'] ?? 'desc';

        $start = $request->start ?? 0;
        $length = $request->length ?? 10;

        $query = Customer::with(['pop', 'area', 'package'])
            ->where('is_delete', '!=', $isDeleteCondition)
            ->when($search, function ($query) use ($search) {
                $query
                    ->where('phone', 'like', "%$search%")
                    ->orWhere('username', 'like', "%$search%")
                    ->orWhereHas('pop', function ($query) use ($search) {
                        $query->where('fullname', 'like', "%$search%");
                    })
                    ->orWhereHas('area', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('package', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            });

        /*Pagination*/
        $paginatedData = $query->orderBy($columnsForOrderBy[$orderByColumn], $orderDirection)->paginate($length, ['*'], 'page', $start / $length + 1);

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => Customer::where('is_delete', '!=', $isDeleteCondition)->count(),
            'recordsFiltered' => $paginatedData->total(),
            'data' => $paginatedData->items(),
        ]);
    }
}
if (!function_exists('send_message')) {
    function send_message(string $phone_number, string $message_text)
    {
        /*---------- SMS API Details -----------**/
        $sms_config = Sms_configuration::latest()->first();
        $api_url = $sms_config->api_url;
        $api_key = $sms_config->api_key;
        $senderid = $sms_config->sender_id;

        /*---------- Prepare data -------------*/
        $data = [
            'api_key' => $api_key,
            'senderid' => $senderid,
            'number' => $phone_number,
            'message' => $message_text,
        ];

        /*---------- Initialize cURL ----------*/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        /*----------- Execute request ------------*/
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        return $responseData;
    }
}

function customer_log($customerId, $actionType, $userId, $description = null)
{
    $object = new Customer_log();
    $object->customer_id = $customerId;
    $object->action_type = $actionType;
    $object->user_id = $userId;
    $object->description = $description;
    $object->ip_address = request()->ip();
    $object->save();
    return $object;
}
if (!function_exists('get_mikrotik_user_info')) {
    function get_mikrotik_user_info($router, string $username)
    {
        try {
            $API = new Client([
                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => (int) $router->port,
            ]);

            /*-----------Active user info (uptime, IP, MAC, interface1)------*/
            $activeQuery = new Query('/ppp/active/print');
            $activeQuery->where('name', $username);
            $active = $API->query($activeQuery)->read()[0] ?? [];

            $interfaceName = $active['interface'] ?? null;

            /*----------- User profile info (from /ppp/secret)------*/
            $secretQuery = new Query('/ppp/secret/print');
            $secretQuery->where('name', $username);
            $secret = $API->query($secretQuery)->read()[0] ?? [];

            /*---------Profile speed (upload/download limit)-----*/
            $profileName = $secret['profile'] ?? null;
            $profileInfo = [];
            if ($profileName) {
                $profileQuery = new Query('/ppp/profile/print');
                $profileQuery->where('name', $profileName);
                $profileInfo = $API->query($profileQuery)->read()[0] ?? [];
            }

            /*-------- Monthly usage estimate-----*/
            $monthlyUsage = null;
            if ($interfaceName) {
                $interfaceList = $API->query(new Query('/interface/print'))->read();
                $interfaceId = null;

                foreach ($interfaceList as $intf) {
                    if ($intf['name'] === $interfaceName) {
                        $interfaceId = $intf['.id'];
                        break;
                    }
                }

                if ($interfaceId) {
                    $monitorQuery = new Query('/interface/monitor-traffic');
                    $monitorQuery->equal('.id', $interfaceId);
                    $monitorQuery->equal('once', '');
                    $usage = $API->query($monitorQuery)->read()[0] ?? [];

                    $rx = $usage['rx-byte'] ?? 0;
                    $tx = $usage['tx-byte'] ?? 0;
                    $monthlyUsage = $rx + $tx;
                }
            }

            /*------Upload & Download speed parsing------*/
            $uploadSpeed = null;
            $downloadSpeed = null;
            if (isset($profileInfo['rate-limit'])) {
                $limits = explode('/', $profileInfo['rate-limit']);
                $uploadSpeed = $limits[0] ?? null;
                $downloadSpeed = $limits[1] ?? null;
            }

            return [
                'interface' => $interfaceName,
                'uptime' => $active['uptime'] ?? null,
                'mac' => $active['caller-id'] ?? null,
                'ip' => $active['address'] ?? null,
                'upload_speed' => $uploadSpeed,
                'download_speed' => $downloadSpeed,
                'monthly_usage' => $monthlyUsage,
                'profile' => $profileName,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }


}


if (!function_exists('formate_uptime')) {
    function formate_uptime($uptime)
    {
        if (empty($uptime) || $uptime === 'N/A') {
            return 'N/A';
        }

        /*--------MikroTik Uptime format parse------*/
        $days = $hours = $minutes = $seconds = 0;

        if (preg_match('/(?:(\d+)d)?(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/', $uptime, $m) && array_filter($m)) {
            $days    = (int) ($m[1] ?? 0);
            $hours   = (int) ($m[2] ?? 0);
            $minutes = (int) ($m[3] ?? 0);
            $seconds = (int) ($m[4] ?? 0);
        }

        $parts = [];

        if ($days > 0)    $parts[] = "{$days}d";
        if ($hours > 0)   $parts[] = "{$hours}h";
        if ($minutes > 0) $parts[] = "{$minutes}m";
        if ($seconds > 0) $parts[] = "{$seconds}s";

        return !empty($parts) ? implode(' ', $parts) : '0s';
    }
}


if (!function_exists('formate_bytes')) {

    function formate_bytes($bytes){
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $power = floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        return number_format( $bytes / pow(1024, $power),2) . ' ' . $units[$power];
    }
}

/**--------------Customer Bill Generate-----------**/
if(!function_exists('customer_bill_generate')){
    function customer_bill_generate($mode='summary',  $filters = []){
         $branch_user_id = Auth::guard('admin')->user()->pop_id ?? null;
        /*------2025-09-----*/
        $currentMonth   = $filters['month'] ?? \Carbon\Carbon::now()->format('Y-m');
        $_query         =\App\Models\Customer::whereRaw("DATE_FORMAT(expire_date, '%Y-%m') = ?", [$currentMonth])
                        ->where('is_delete', '0')
                        ->whereIn('status', ['active', 'online', 'offline']);
        /*--- Check Branch User or Admin -----*/
        if ($branch_user_id) {
            $_query->where('pop_id', $branch_user_id);
        }
        /*--------Filter With Pop Branch*/
        if(!empty($filters['pop_id'])){
            $_query->where('pop_id', $filters['pop_id']);
        }
        /*--------Filter With Area*/
        if(!empty($filters['area_id'])){
            $_query->where('area_id', $filters['area_id']);
        }
        /*--------Filter With Customer Id*/
        if(!empty($filters['customer_id'])){
            $_query->where('id', $filters['customer_id']);
        }

        $get_all_customer_ids = $_query->pluck('id')->toArray();

        $get_paid_customer_ids = \App\Models\Customer_recharge::where('recharge_month', $currentMonth)
            ->pluck('customer_id')
            ->toArray();
        /*------ Find customers whose bills are not paid-----*/
        $unpaid_customer_ids = array_diff($get_all_customer_ids, $get_paid_customer_ids);
        /*--------------- Get the unpaid customers' data--------------*/
        $customers = \App\Models\Customer::with(['pop', 'area'])
            ->whereIn('id', $unpaid_customer_ids)
            ->get()
            ->keyBy('id');

        $rows = [];
        $total_due = 0;

        foreach ($unpaid_customer_ids as $customer_id) {
            $customer = $customers[$customer_id] ?? null;
            if (!$customer) continue;
            $total_due += floatval($customer->amount ?? 0);
            $rows[] = [
                'id' => $customer->id,
                'username' => '<a href="'.route('admin.customer.view', $customer->id).'" style="display: flex; align-items: center; text-decoration: none; color: #333;">&nbsp;<span style="font-size: 16px; font-weight: bold;">'.$customer->username.'</span>'.'</a>',
                'pop' => '<span><i class="fas fa-broadcast-tower" style="color: #28a745; margin-right: 6px;"></i>'.($customer->pop->name ?? '-').'</span>',

                'area' => '<span><i class="fas fa-map-marker-alt" style="color: #dc3545; margin-right: 6px;"></i>'.($customer->area->name ?? '-').'</span>',

                'phone' => '<span><i class="fas fa-phone-alt" style="color: #007bff; margin-right: 6px;"></i>'.($customer->phone ?? '-').'</span>',
                'month' => ''.\Carbon\Carbon::parse($currentMonth)->format('F Y').'',
                'price' => '<span style="font-size: 16px; font-weight: bold; color:red;">' . $customer->amount . '</span>',
            ];
        }
        if($mode=='summary'){
            return $total_due;
        }
        return [
            'rows'       => $rows,
            'total_due'  => $total_due,
            'month'      => $currentMonth,
        ];
    }

}
/**--------------Customer Over Due List-----------**/
if (!function_exists('customer_over_due_list')) {
    function customer_over_due_list($mode = 'summary', $filters = []) {
        $branch_user_id = Auth::guard('admin')->user()->pop_id ?? null;

        $customerIdsQuery = Customer_recharge::select('customer_id')->distinct();

        /*--- Check Branch User or Admin -----*/
        if ($branch_user_id) {
            $customerIdsQuery->whereHas('customer', function ($q) use ($branch_user_id) {
                $q->where('pop_id', $branch_user_id);
            });
        }

        /*-------- Filter With Pop Branch (from $filters) --------*/
        if (!empty($filters['pop_id'])) {
            $customerIdsQuery->whereHas('customer', function ($q) use ($filters) {
                $q->where('pop_id', $filters['pop_id']);
            });
        }

        /*-------- Filter With Area (from $filters) --------*/
        if (!empty($filters['area_id'])) {
            $customerIdsQuery->whereHas('customer', function ($q) use ($filters) {
                $q->where('area_id', $filters['area_id']);
            });
        }

        /*-------- Filter With Month --------*/
        if (!empty($filters['month'])) {
            $customerIdsQuery->where('recharge_month', 'like', $filters['month'] . '%');
        }

        $customerIds = $customerIdsQuery->pluck('customer_id')->toArray();

        // handle empty result in a mode-consistent way
        if (empty($customerIds)) {
            if ($mode === 'summary') {
                return 0;
            }
            return [
                'rows'      => [],
                'total_due' => 0,
                'month'     => $filters['month'] ?? '--',
            ];
        }

        $customers = Customer::with(['pop', 'area'])->whereIn('id', $customerIds)->get()->keyBy('id');

        $rechargesGrouped = Customer_recharge::whereIn('customer_id', $customerIds)
            ->whereMonth('created_at', '!=', date('m'))
            // ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy('customer_id');

        $rows = [];
        $total_due_all = 0;

        foreach ($customerIds as $customer_id) {
            $customer = $customers[$customer_id] ?? null;
            if (!$customer) continue;

            $customerRecharges = $rechargesGrouped->get($customer_id, collect());

            $credit_recharges = $customerRecharges->where('transaction_type', 'credit');
            $due_paids = $customerRecharges->where('transaction_type', 'due_paid');

            $paid_months = $due_paids->flatMap(function($row) {
                return array_map('trim', explode(',', $row->recharge_month ?? ''));
            })->filter()->unique()->values()->toArray();

            $unpaid_credits = [];
            $total_due = 0.0;

            foreach ($credit_recharges as $credit) {
                $raw_month_field = $credit->recharge_month ?? '';
                $months = array_values(array_filter(array_map('trim', explode(',', $raw_month_field))));

                if (empty($months)) {
                    continue;
                }

                $per_month_amount = $credit->amount;
                $months_count = count($months);
                if ($months_count > 1) {
                    $per_month_amount = $credit->amount / $months_count;
                }

                foreach ($months as $month) {
                    if ($month === '') continue;
                    if (!in_array($month, $paid_months)) {
                        try {
                            $label = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
                        } catch (\Exception $e) {
                            try {
                                $label = \Carbon\Carbon::parse($month . '-01')->format('F Y');
                            } catch (\Exception $e2) {
                                $label = $month;
                            }
                        }

                        $unpaid_credits[] = $label;
                        $total_due += (float) $per_month_amount;
                    }
                }
            }

            $total_recharge = (float) $customerRecharges->where('transaction_type', '!=', 'due_paid')->sum('amount');
            $total_paid = (float) $customerRecharges->where('transaction_type', '!=', 'credit')->sum('amount');

            $total_due = round($total_due, 2);
            $total_recharge = round($total_recharge, 2);
            $total_paid = round($total_paid, 2);

            if ($total_due > 0) {
                $total_due_all += $total_due;
                $rows[] = [
                    'id' => $customer->id,
                    'username' =>
                        '<a href="'.route('admin.customer.view', $customer->id).'" style="display: flex; align-items: center; text-decoration: none; color: #333;">&nbsp;<span style="font-size: 16px; font-weight: bold;">'.$customer->username.'</span>'
                        .'</a>',

                    'pop' => '<span><i class="fas fa-broadcast-tower" style="color: #28a745; margin-right: 6px;"></i>'.($customer->pop->name ?? '-').'</span>',

                    'area' => '<span><i class="fas fa-map-marker-alt" style="color: #dc3545; margin-right: 6px;"></i>'.($customer->area->name ?? '-').'</span>',

                    'phone' => '<span><i class="fas fa-phone-alt" style="color: #007bff; margin-right: 6px;"></i>'.($customer->phone ?? '-').'</span>',

                    'month' => implode('<br>', array_unique($unpaid_credits)),

                    'recharged' => '<span style="font-size: 16px; font-weight: bold; color:green;"> '.$total_recharge.'</span>',

                    'paid' => '<span style="font-size: 16px; font-weight: bold; color:black;"> '.$total_paid.'</span>',

                    'due' => '<span style="font-size: 16px; font-weight: bold; color:red;"> '.$total_due.'</span>',
                ];
            }
        }

        if ($mode == 'summary') {
            return round($total_due_all, 2);
        }

        return [
            'rows'      => $rows,
            'total_due' => round($total_due_all, 2),
            'month'     => $filters['month'] ?? '--',
        ];
    }
}


/*---------Router Activation ---------*/
if (!function_exists('router_activation')) {
    function router_activation(int $customer_id){
        $customer = Customer::with('package')->find($customer_id);

        if (!$customer) {
            Log::error("Router Activation Failed: Customer ID {$customer_id} not found.");
            return;
        }
        $packageName = trim($customer->package->mikrotik_profile ?? $customer->package->name ?? '');

        if (empty($packageName)) {
            Log::error("Router Activation Failed: Package profile not set for Customer ID {$customer_id}");
            return false;
        }
        $router = Mikrotik_router::where('status', 'active')->find($customer->router_id);

        if (!$router) {
            Log::error("Active Router not found for Customer ID {$customer_id} (Router ID: {$customer->router_id})");
            return false;
        }
        if ($router) {
            $client = new Client([
                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => (int) ($router->port ?? 8728),
            ]);

            try {
                $client->connect();

                /*--------- Find secret ---------*/
                $username    = trim($customer->username);
                $secretQuery = (new Query('/ppp/secret/print'))->where('name', $username);
                $secrets     = $client->query($secretQuery)->read();

                if (!empty($secrets)) {
                    $secretId    = $secrets[0]['.id'];
                    /*---------- Enable Secret & Update Package ---------*/
                    $setQuery = (new Query('/ppp/secret/set'))
                        ->equal('.id', $secretId)
                        ->equal('profile', $packageName)
                        ->equal('disabled', 'no');
                    if (!empty($customer->password)) {
                        $setQuery->equal('password', trim($customer->password));
                    }
                    $client->query($setQuery)->read();
                } else {
                    $addQuery = (new Query('/ppp/secret/add'))
                    ->equal('name', $username)
                    ->equal('password', trim($customer->password))
                    ->equal('service', 'pppoe')
                    ->equal('profile', trim($packageName))
                    ->equal('disabled', 'no');
                    $client->query($addQuery)->read();
                }
                /*---------- Disconnect Active Session---------*/
                $activeQuery = (new Query('/ppp/active/print'))->where('name', $username);
                $active_users = $client->query($activeQuery)->read();
                if (!empty($active_users)) {
                    foreach ($active_users as $user) {
                        $removeQuery = (new Query('/ppp/active/remove'))->equal('.id', $user['.id']);
                        $client->query($removeQuery)->read();
                    }
                }
                /*------------ Status update in DB ---------*/
                $customer->status = 'active';
                $customer->save();

            } catch (\Exception $e) {
                Log::error("Router connection or enabling failed for Customer ID {$customer_id}: " . $e->getMessage());
            }
        } else {
            Log::error("Active Router not found for Customer ID {$customer_id} (Router ID: {$customer->router_id})");
        }
    }
}
/**--------------Delete Customer From Mikrotik-----------**/
if (!function_exists('delete_mikrotik_user')) {
    function delete_mikrotik_user(int $customer_id){
        /*--------- Fetch the customer data------------*/
        $customer = Customer::find($customer_id);

        if ($customer && $customer->router_id) {
            $router = Mikrotik_router::where('status', 'active')->find($customer->router_id);
            if ($router) {
                $client = new Client([
                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => (int) $router->port ?? 8728,
                ]);

                try {
                    $client->connect();
                    $secretQuery = (new Query('/ppp/secret/print'))->where('name', $customer->username);
                    $secrets = $client->query($secretQuery)->read();

                    if (!empty($secrets)) {
                        $secretId = $secrets[0]['.id'];

                        /*-------Remove active PPP session if exists---------*/
                        $activeQuery = (new Query('/ppp/active/print'))->where('name', $customer->username);
                        $activeUser = $client->query($activeQuery)->read();

                        if (!empty($activeUser)) {
                            $activeId = $activeUser[0]['.id'];
                            $removeQuery = (new Query('/ppp/active/remove'))->equal('.id', $activeId);
                            $client->query($removeQuery)->read();
                        }

                        /*****---------Remove the secret------------****/
                        $removeSecretQuery = (new Query('/ppp/secret/remove'))->equal('.id', $secretId);
                        $client->query($removeSecretQuery)->read();
                    }

                } catch (\Exception $e) {
                    Log::error("Mikrotik router connection or operation failed: " . $e->getMessage());
                }
            }
        } else {
            Log::error("Customer or router not found for customer ID: " . $customer_id);
        }
    }
}
/*-------------Customer Add From Mikrotik----------*/
if (!function_exists('add_mikrotik_user')) {
    function add_mikrotik_user(int $customer_id){
        /*--------- Fetch the customer data------------*/
        $customer = Customer::find($customer_id);

        if ($customer && $customer->router_id) {
            $router = Mikrotik_router::where('status', 'active')->find($customer->router_id);
            if ($router) {
                $client = new Client([
                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => (int) $router->port ?? 8728,
                ]);

                try {
                    $client->connect();

                    /*-----Load MikroTik Profile list------*/
                    $mikrotik_profile_list = new Query('/ppp/profile/print');
                    $profiles = $client->query($mikrotik_profile_list)->read();

                    /*-----Find profile name from Branch Package-----*/
                    $profileName = Branch_package::find($customer->package_id)->name;

                    /*------Check if the profile name exists in MikroTik-----*/
                    $profileExists = collect($profiles)->pluck('name')->contains(trim($profileName));

                    if (!$profileExists) {
                        /*---------- Log the error if profile does not exist--------*/
                        Log::error("MikroTik profile '{$profileName}' does not exist for customer ID: {$customer->id}");
                        return response()->json([
                            'success' => false,
                            'message' => "MikroTik profile '{$profileName}' does not exist. Please check your package configuration.",
                        ]);
                    }

                    /*--------Check if the customer already exists in MikroTik------*/
                    $check_Query = new Query('/ppp/secret/print');
                    $check_Query->where('name', $customer->username);
                    $check_customer = $client->query($check_Query)->read();

                    /*------- If customer does not exist, create a new PPP secret-------*/
                    if (empty($check_customer)) {
                        $query = new Query('/ppp/secret/add');
                        $query->equal('name', $customer->username);
                        $query->equal('password', $customer->password);
                        $query->equal('service', 'pppoe');
                        $query->equal('profile', $profileName);
                        $client->query($query)->read();
                    }

                    /*---------Disconnect client after operation-------*/
                    //$client->disconnect();
                } catch (\Exception $e) {
                    Log::error("Mikrotik router connection or operation failed for customer ID: {$customer->id} - " . $e->getMessage());
                }
            } else {
                Log::error("Router not found for customer ID: {$customer->id}");
            }
        } else {
            /*------- Log if the customer is not found----*/
            Log::error("Customer not found for ID: {$customer_id}");
        }
    }
}
/*----------------------MikroTik Secret Enable Helper-------------*/
if (!function_exists('enable_mikrotik_user')) {
    function enable_mikrotik_user(Customer $customer): bool
    {
        $router = Mikrotik_router::where('status', 'active')->find($customer->router_id);

        if (!$router) {
            Log::error("MikroTik Enable Failed: Router not found or inactive for Customer ID {$customer->id}");
            return false;
        }

        try {
            $client = new Client([
                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => (int) ($router->port ?? 8728),
            ]);

            $client->connect();

            // Find Secret
            $secretQuery = (new Query('/ppp/secret/print'))->where('name', trim($customer->username));
            $secrets     = $client->query($secretQuery)->read();

            if (empty($secrets)) {
                Log::warning("MikroTik Secret not found for enable: {$customer->username}");
                return false;
            }

            $secretId    = $secrets[0]['.id'];
            $packageName = trim($customer->package->mikrotik_profile ?? $customer->package->name ?? '');

            // Enable Secret & Set Package Profile
            $setQuery = (new Query('/ppp/secret/set'))
                ->equal('.id', $secretId)
                ->equal('disabled', 'no');

            if (!empty($packageName)) {
                $setQuery->equal('profile', $packageName);
            }

            $client->query($setQuery)->read();

            return true;

        } catch (\Exception $e) {
            Log::error("MikroTik Enable Error (Customer ID: {$customer->id}): " . $e->getMessage());
            return false;
        }
    }
}
/*---------- MikroTik Secret Disable & Kick Active Session Helper-------*/
if (!function_exists('disable_mikrotik_user')) {
    function disable_mikrotik_user(Customer $customer): bool
    {
        $router = Mikrotik_router::where('status', 'active')->find($customer->router_id);

        if (!$router) {
            Log::error("MikroTik Disable Failed: Router not found or inactive for Customer ID {$customer->id}");
            return false;
        }

        try {
            $client = new Client([
                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => (int) ($router->port ?? 8728),
            ]);

            $client->connect();

            // Find Secret
            $secretQuery = (new Query('/ppp/secret/print'))->where('name', trim($customer->username));
            $secrets     = $client->query($secretQuery)->read();

            if (empty($secrets)) {
                Log::warning("MikroTik Secret not found for disable: {$customer->username}");
                return false;
            }

            $secretId = $secrets[0]['.id'];

            // 1. Disable Secret
            $setQuery = (new Query('/ppp/secret/set'))
                ->equal('.id', $secretId)
                ->equal('disabled', 'yes');

            $client->query($setQuery)->read();

            // 2. Disconnect Active Connections
            $activeQuery = (new Query('/ppp/active/print'))->where('name', trim($customer->username));
            $activeUsers = $client->query($activeQuery)->read();

            if (!empty($activeUsers)) {
                foreach ($activeUsers as $user) {
                    $removeQuery = (new Query('/ppp/active/remove'))->equal('.id', $user['.id']);
                    $client->query($removeQuery)->read();
                }
            }

            return true;

        } catch (\Exception $e) {
            Log::error("MikroTik Disable Error (Customer ID: {$customer->id}): " . $e->getMessage());
            return false;
        }
    }
}
/**--------------Add Radius User-----------**/
if (!function_exists('add_radius_user')) {
    function add_radius_user(int $customer_id){
     $customer = Customer::find($customer_id);
        if (!$customer) {
            Log::error("Radius: Customer not found ID {$customer_id}");
            return;
        }

        try {

            /**---------- check exists -------*/
            $exists = Radcheck::where('username', trim($customer->username))->exists();

            if (!$exists) {
                Radcheck::create([
                    'username'  => trim($customer->username),
                    'attribute' => 'Cleartext-Password',
                    'op'        => ':=',
                    'value'     => trim($customer->password)
                ]);
            }

            /**------------ package ---------*/
            $package = Branch_package::find(trim($customer->package_id));

            if (!$package) {
                Log::error("Radius: Package not found for customer {$customer->id}");
                return;
            }
            /**-------------- remove old reply ----------*/
            DB::connection('radius')->table('radreply')
                ->where('username', trim($customer->username))
                ->delete();

            /**---------- insert reply ------------*/
            DB::connection('radius')->table('radreply')->insert([
                'username'  => trim($customer->username),
                'attribute' => 'Mikrotik-Group',
                'op'        => ':=',
                'value'     => trim($package->name),
            ]);

        } catch (\Exception $e) {
            Log::error("Radius add user failed: " . $e->getMessage());
        }
   }
}
/**--------------Update Radius User-----------**/
if (!function_exists('update_radius_user')) {
    function update_radius_user(int $customer_id){
        $customer = Customer::find($customer_id);
        if (!$customer) return;

        try {

            /**-------- update password ------*/
            DB::connection('radius')->table('radcheck')
                ->where('username', $customer->username)
                ->update([
                    'value' => $customer->password
                ]);

            /** update profile */
            $package = Branch_package::find($customer->package_id);

            DB::connection('radius')->table('radreply')
                ->where('username', $customer->username)
                ->delete();

            DB::connection('radius')->table('radreply')->insert([
                'username'  => $customer->username,
                'attribute' => 'Mikrotik-Group',
                'op'        => ':=',
                'value'     => $package->name,
            ]);

        } catch (\Exception $e) {
            Log::error("Radius update failed: " . $e->getMessage());
        }
   }
}
/**--------------Disable Radius User-----------**/
if (!function_exists('disable_radius_user')) {
   function disable_radius_user(string $username)
    {
        try {

            DB::connection('radius')->table('radcheck')
                ->where('username', $username)
                ->delete();

        } catch (\Exception $e) {
            Log::error("Radius disable failed: " . $e->getMessage());
        }
    }
}
/**--------------Enable Radius User-----------**/
if (!function_exists('enable_radius_user')) {
   function enable_radius_user(int $customer_id)
    {
        add_radius_user($customer_id);
    }
}
/**--------------Delete Radius User-----------**/
if (!function_exists('delete_radius_user')) {
   function delete_radius_user(string $username)
    {
       try {
            DB::connection('radius')->table('radcheck')
                ->where('username', $username)
                ->delete();

            DB::connection('radius')->table('radreply')
                ->where('username', $username)
                ->delete();

        } catch (\Exception $e) {
            Log::error("Radius delete failed: " . $e->getMessage());
        }
    }
}
/**--------------Get Live Onu Signal-----------**/
if (!function_exists('get_live_onu_signal')) {
    function get_live_onu_signal($onu){

        try {
            $device = \App\Models\Olt_device::find($onu->olt_id);
            if (!$device) {
                return [
                    'success' => false,
                    'error_message' => 'OLT device not found'
                ];
            }

            /*-----------VSOL Brand OLT-------*/
            if (strtoupper($device->brand) === 'VSOL') {
                $telnet = new TelnetClient($device->ip_address,$device->port,$device->username,$device->password);
                $telnet->connect()->login();
                $driver = new VsolDriver($telnet,strtolower($device->mode),$device->password);
                $lastSlash = strrchr($onu->pon_port, '/');
                $portNumber = $lastSlash ? (int) substr($lastSlash, 1) : 0;
                return $driver->getSingleOnuSignal($portNumber,$onu->onu_id);
            }

            /*-----------BECOM Brand OLT-------*/
            if (strtoupper($device->brand) === 'BDCOM') {
                $telnet = new TelnetClient($device->ip_address,$device->port,$device->username,$device->password);
                $telnet->connect()->login();
                $driver = new BdcomDriver( $telnet,strtolower($device->mode));
                return $driver->getSingleOnuSignal($onu->interface_name);
            }
            if (strtoupper($device->brand) === 'FOCUSCOM') {
                $focuscom_driver = new FocuscomDriver(
                    $device->ip_address,
                    $device->port,
                    $device->username,
                    $device->password,
                    strtolower($device->mode)
                );
                return $focuscom_driver->getSingleOnuSignal(trim($onu->interface_name));
            }

            return [
                'success' => false,
                'error_message' => 'Unsupported OLT'
            ];

        } catch (\Exception $e) {
            return [
                'success'       => false,
                'error_message' => $e->getMessage()
            ];
        }
    }
}
/**--------------Get Tenants-----------**/
if (!function_exists('get_system_tenant')) {
    function get_system_tenant(){
        $host = request()->getHost();

        return Cache::store(config('cache.default'))->remember(
            "tenant:lookup:{$host}",
            now()->addMinutes(5),
            function () use ($host) {
                return DB::connection('mysql')
                    ->table('tenants')
                    ->where('subdomain', $host)
                    ->first();
            }
        );
    }
}
/*---------Customer Status------------*/
// if (!function_exists('get_customer_status')) {
//     function get_customer_status($pop_id = null) {
//         $branch_user_id = $pop_id;
//         $domain = request()->getHost();

//         $cacheKey = "customer_status_{$domain}_pop_" . ($branch_user_id ?? 'all');

//         return Cache::remember($cacheKey, now()->addSeconds(10), function () use ($branch_user_id) {

//             /* ------- Customer status -------*/
//             $_customer_status = Customer::where('is_delete', 0)
//                 ->when($branch_user_id, fn($q) => $q->where('pop_id', $branch_user_id))
//                 ->selectRaw("
//                     COUNT(*) as total_customer,
//                     SUM(CASE WHEN status='expired' THEN 1 ELSE 0 END) as expire_customer,
//                     SUM(CASE WHEN status='disabled' THEN 1 ELSE 0 END) as disable_customer,
//                     SUM(CASE WHEN status='discontinue' THEN 1 ELSE 0 END) as discontinue_customer,
//                     SUM(CASE WHEN status='active' THEN 1 ELSE 0 END) as active_customer,
//                     SUM(CASE WHEN amount=0 THEN 1 ELSE 0 END) as free_customer
//                 ")
//                 ->first();

//             $total_customer       = (int) ($_customer_status->total_customer ?? 0);
//             $expire_customer      = (int) ($_customer_status->expire_customer ?? 0);
//             $disable_customer     = (int) ($_customer_status->disable_customer ?? 0);
//             $discontinue_customer = (int) ($_customer_status->discontinue_customer ?? 0);
//             $free_customer        = (int) ($_customer_status->free_customer ?? 0);
//             $active_customer      = (int) ($_customer_status->active_customer ?? 0);

//             $all_online_usernames = [];

//             /*-------------  Radius Active Sessions -------------*/
//             if (Schema::hasTable('radacct')) {
//                 try {
//                     $radiusUsers = Radacct::whereNull('acctstoptime')
//                         ->pluck('username')
//                         ->map(fn($u) => trim($u))
//                         ->toArray();

//                     $all_online_usernames = array_merge($all_online_usernames, $radiusUsers);
//                 } catch (\Exception $e) {
//                     Log::warning("Radius Query Failed: " . $e->getMessage());
//                 }
//             }

//             /*------------- MikroTik Active Users -------------*/
//             $routers = Mikrotik_router::where('status', 'active')
//                 ->when($branch_user_id, fn($q) => $q->where('pop_id', $branch_user_id))
//                 ->get(['ip_address', 'username', 'password', 'port']);

//             foreach ($routers as $routerInfo) {
//                 try {
//                     $API = new RouterosAPI();
//                     $API->debug = false;
//                     $API->timeout = 2;

//                     if ($API->connect(
//                         $routerInfo->ip_address,
//                         $routerInfo->username,
//                         $routerInfo->password,
//                         (int) ($routerInfo->port ?? 8728)
//                     )) {
//                         $rawActive = $API->comm('/ppp/active/print');

//                         if (is_array($rawActive)) {
//                             foreach ($rawActive as $row) {
//                                 if (!empty($row['name'])) {
//                                     $all_online_usernames[] = trim($row['name']);
//                                 }
//                             }
//                         }
//                         $API->disconnect();
//                     }
//                 } catch (\Exception $e) {
//                     Log::warning("MikroTik Connection Failed for Router IP [{$routerInfo->ip_address}]: " . $e->getMessage());
//                 }
//             }

//             $unique_online_usernames = array_unique($all_online_usernames);

//             /*------------- Get Online Customer -------------*/
//             $online_customer = 0;

//             if ($active_customer > 0 && !empty($unique_online_usernames)) {
//                 $online_customer = Customer::where('is_delete', 0)
//                     ->where('status', 'active')
//                     ->when($branch_user_id, fn($q) => $q->where('pop_id', $branch_user_id))
//                     ->whereIn('username', $unique_online_usernames)
//                     ->count();
//             }

//             $offline_customer = max(0, $active_customer - $online_customer);

//             /*------------- Response Data -------------*/
//             return response()->json([
//                 'status' => true,
//                 'data'   => [
//                     'online'      => $online_customer,
//                     'offline'     => $offline_customer,
//                     'active'      => $active_customer,
//                     'expired'     => $expire_customer,
//                     'disabled'    => $disable_customer,
//                     'discontinue' => $discontinue_customer,
//                     'free'        => $free_customer,
//                     'total'       => $total_customer,
//                 ]
//             ]);
//         });
//     }
// }
if (!function_exists('get_customer_status')) {
    function get_customer_status($pop_id = null) {
        $branch_user_id = $pop_id ?? 0;

        $summary = DB::table('dashboard_summaries')
            ->where('pop_id', $branch_user_id)
            ->first();

        return response()->json([
            'status' => true,
            'data'   => [
                'online'      => (int) ($summary->online ?? 0),
                'offline'     => (int) ($summary->offline ?? 0),
                'active'      => (int) ($summary->active ?? 0),
                'expired'     => (int) ($summary->expired ?? 0),
                'disabled'    => (int) ($summary->disabled ?? 0),
                'discontinue' => (int) ($summary->discontinue ?? 0),
                'free'        => (int) ($summary->free ?? 0),
                'total'       => (int) ($summary->total ?? 0),
            ]
        ]);
    }
}
/*---------Customer Single Recharge------------*/
if(!function_exists('process_customer_single_recharge')){
    function process_customer_single_recharge(int $customerId, $validMonths, $transactionType, $payableAmount, $note = null, $voucherNo = null){
        $customer = Customer::find($customerId);
        if (!$customer) {
            return ['success' => false, 'message' => "Customer not found."];
        }
        $monthsCount = count($validMonths);
        $graceRecharge = Grace_recharge::where('customer_id', $customer->id)->first();
        $graceDays = 0;
        if ($graceRecharge) {
            $graceDays = $graceRecharge->days;
            if ($customer->expire_date) {
                $customer->expire_date = Carbon::parse($customer->expire_date)->subDays($graceDays)->toDateString();
            }
            $graceRecharge->delete();
        }
        /*-----------Base Date Collection------------*/
        $currentExpire = $customer->expire_date ? Carbon::parse($customer->expire_date) : null;
        if ($currentExpire && $currentExpire->isFuture()) {
            $baseDate = $currentExpire;
        } else {
            $baseDate = Carbon::now();
        }
        /*--------Monthly Billing-----------*/
        if ($customer->billing_type === 'monthly' && !empty($customer->billing_cycle)) {
            $targetDate = $baseDate->copy()->addMonthsNoOverflow($monthsCount);
            $cycleDay = (int) $customer->billing_cycle; 
            $daysInMonth = $targetDate->daysInMonth;    
            $actualDay = min($cycleDay, $daysInMonth);
            $newExpireDate = $targetDate->setDay($actualDay)->toDateString();
        } else {
            /*--------Date to Date Billing-----------*/
            $newExpireDate = $baseDate->copy()->addMonthsNoOverflow($monthsCount)->toDateString();
        }
        $rechargeMonthsString = implode(',', $validMonths);
        $purchasePrice = Branch_package::where('id', $customer->package_id)->value('purchase_price') ?? 0;
        /*---------Create Customer Recharge----------*/
        $object = new Customer_recharge();
        $object->user_id          = auth()->guard('admin')->id();
        $object->customer_id      = $customer->id;
        $object->pop_id           = $customer->pop_id;
        $object->area_id          = $customer->area_id;
        $object->recharge_month   = $rechargeMonthsString;
        $object->transaction_type = $transactionType;
        $object->amount           = $payableAmount;
        $object->purchase_price   = $purchasePrice;
        $object->paid_until       = $newExpireDate;
        $object->note             = $note ?? 'Recharge Completed';
        $object->voucher_no       = $voucherNo;
        $object->save();

        /*----------Customer Expire Date Update----------*/
        $customer->expire_date = $newExpireDate;
        $customer->save();
        /*----------Customer Logs----------*/
        if ($graceDays > 0) {
            customer_log($customer->id, 'recharge', auth()->guard('admin')->id(), 'Customer Grace Recharge Remove!');
        }
        customer_log($customer->id, 'recharge', auth()->guard('admin')->id(), 'Customer Recharge Completed!');
        /*----------Customer Status Activation----------*/
        if (!empty($customer->connection_type)) {
            if ($customer->connection_type === 'radius') {
                add_radius_user($customer->id);
            } elseif ($customer->connection_type === 'pppoe') {
                if ($customer->status !== 'active') {
                    router_activation($customer->id);
                }
            }
        }

        return [
            'success' => true,
            'message' => 'Recharge successfully.',
            'customer' => $customer
        ];
    }
}


