<?php
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\Admin\LoginLogController;
use App\Http\Controllers\Backend\HeroController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use RouterOS\Client;
use RouterOS\Query;
use function App\Helpers\formate_uptime;
use Illuminate\Support\Facades\Auth;

/*Backend Route*/

Route::get('/admin/login', [AdminController::class, 'login_form'])->name('admin.login');

Route::post('login-functionality', [AdminController::class, 'login_functionality'])->name('login.functionality');

Route::group(['middleware' => 'admin'], function () {

    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    /*----------- User Management  Route ----------*/
    Route::prefix('admin/hero-section')->group(function () {
        Route::controller(HeroController::class)->group(function () {
            Route::get('/index', 'index')->name('admin.hero_section.index');
            Route::post('/hero-section/update', 'update')->name('admin.hero.update');
        });        
    });
    Route::get('/test',function(){
        return view('test');
    });
});
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return 'Optimize Clear Completed';
});

