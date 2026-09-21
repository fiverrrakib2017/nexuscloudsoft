<?php

namespace App\Http\Controllers\Backend\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Login_log;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\PermissionRegistrar;
class LoginLogController extends Controller
{
    public function index()
    {
        return view('Backend.Pages.User.login_activity');
    }
    public function delete(Request $request)
    {
        $log = Login_log::find($request->id);

        if (!$log) {

            return response()->json([
                'success' => false,
                'message' => 'Log Not Found'
            ]);
        }

        $log->delete();

        return response()->json([
            'success' => true,
            'message' => 'Log Deleted Successfully'
        ]);
    }
    public function get_data(Request $request)
    {
        $query = Login_log::query();

        if ($request->from_date) {

            $query->whereDate(
                'login_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'login_at',
                '<=',
                $request->to_date
            );
        }

        $logs = $query
            ->latest('login_at')
            ->get();

        return response()->json($logs);
    }
}
