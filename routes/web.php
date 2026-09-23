<?php

use App\Http\Controllers\Backend\AboutController;
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
// Frontend Controllers
use App\Http\Controllers\Frontend\HomeController;
/*Backend Route*/

Route::get('/admin/login', [AdminController::class, 'login_form'])->name('admin.login');

Route::post('login-functionality', [AdminController::class, 'login_functionality'])->name('login.functionality');

Route::group(['middleware' => 'admin'], function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    /*----------- Hero Section Management  Route ----------*/
    Route::prefix('admin/hero-section')->group(function () {
        Route::controller(HeroController::class)->group(function () {
            Route::get('/index', 'index')->name('admin.hero_section.index');
            Route::post('/hero-section/update', 'update')->name('admin.hero.update');
        });        
    });
    /*----------- About Section Management  Route ----------*/
    Route::prefix('admin/about-section')->group(function () {
        Route::controller(AboutController::class)->group(function () {
            Route::get('/index', 'index')->name('admin.about_section.index');
            Route::post('/about-section/update', 'update')->name('admin.about.update');
        });        
    });
    Route::get('/test',function(){
        return view('test');
    });
});

/*-----------Frontend Route-------------*/
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    // Route::get('/about', 'about')->name('about');
    // Route::get('/services', 'services')->name('services');
    // Route::get('/contact', 'contact')->name('contact');
    // Route::post('/demo-request', 'storeDemoRequest')->name('demo.request.store');
});