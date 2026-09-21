<?php

namespace App\Http\Controllers\Backend\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Customer_Invoice;
use App\Models\Pop_area;
use App\Models\Product;
use App\Models\Product_Order;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier;
use App\Models\Router;
use App\Models\Customer_recharge;
use App\Models\Ticket;
use App\Models\Admin;
use App\Models\Login_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Services\DateService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use function App\Helpers\customer_bill_generate;
use function App\Helpers\get_customer_status;
use function App\Helpers\customer_over_due_list;
use App\Services\RouterosAPI;
use App\Models\Radius\Radacct;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
class AdminController extends Controller
{
    protected $dateService;

    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }
    public function login_form(){
        return view('Backend.Pages.Login.Login');
    }

    public function get_data(Request $request) {
        if ($request->data == 'customer_status_data') {
            $pop_id=Auth::guard('admin')->user()->pop_id ?? null;
           return get_customer_status($pop_id);
        }
    }

    public function login_functionality(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        /*------- Try Admin Login Only ------*/
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            if (Auth::guard('admin')->attempt(['email' => $login, 'password' => $password])) {
                $request->session()->regenerate();
                Cache::flush();


                return redirect()->intended(route('admin.dashboard'));
            }
        }

        return back()->with('error-message', 'Invalid Email or Password')->withInput();
    }
    
    public function dashboard()
    {

        /* ------ Render View ------- */
        return view('Backend.Pages.Dashboard.index');
    }
    public function server_info()
    {
        $ramUsage = shell_exec("free -m | awk 'NR==2{printf \"%.2f\", $3*100/$2 }'");
        $cpuUsage = shell_exec("top -bn1 | grep 'Cpu(s)' | awk '{print 100 - $8}'");
        $diskUsage = shell_exec("df -h / | awk 'NR==2{print $5}'");

        $ramInfo = shell_exec("free -m | awk 'NR==2{print $2 \",\" $3}'");
        list($totalRam, $usedRam) = explode(',', trim($ramInfo));

        $cpuCores = trim(shell_exec("nproc"));
        $cpuModel = trim(shell_exec("lscpu | grep 'Model name' | awk -F ':' '{print $2}'"));

        $diskInfo = shell_exec("df -h / | awk 'NR==2{print $2 \",\" $3}'");
        list($diskTotal, $diskUsed) = explode(',', trim($diskInfo));

        $uptime = shell_exec("uptime -p");
        $hostname = shell_exec("hostname");

        return response()->json([
            'ram_usage' => trim($ramUsage) . '%',
            'ram_total' => $totalRam . ' MB',
            'ram_used' => $usedRam . ' MB',

            'cpu_usage' => trim($cpuUsage) . '%',
            'cpu_cores' => $cpuCores,
            'cpu_model' => $cpuModel,

            'disk_usage' => trim($diskUsage),
            'disk_total' => $diskTotal,
            'disk_used' => $diskUsed,

            'uptime' => trim($uptime),
            'hostname' => trim($hostname),
        ]);
    }

    public function logout(){
        $sessionId = session()->getId();

        $log = Login_log::where('session_id', $sessionId)
            ->where('user_type', 'admin')
            ->whereNull('logout_at')
            ->latest()
            ->first();

        if ($log) {

            $log->logout_at = now();

            $log->save();
        }

        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
