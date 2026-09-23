<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
class AdminController extends Controller
{
    
    public function login_form(){
        return view('Backend.Pages.Login.Login');
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
   

    public function logout(){
        session()->getId();
        Auth::guard('admin')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
