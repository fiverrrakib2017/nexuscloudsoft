<?php

use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\ValueController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\Admin\LoginLogController;
use App\Http\Controllers\Backend\HeroController;
use App\Http\Controllers\Backend\StatController;
use App\Http\Controllers\Backend\FeatureController;
use App\Http\Controllers\Backend\AltFeatureController;
use App\Http\Controllers\Backend\PricingController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\TeamController;
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
    /*-----------Values / Why Choose Us Routes ----------*/
    Route::prefix('admin/values-section')->group(function () {
        Route::controller(ValueController::class)->group(function () {
            Route::get('/', 'index')->name('admin.values.index');
            Route::post('/header-update', 'updateHeader')->name('admin.values.header.update');
            Route::get('/get-cards', 'getCards')->name('admin.values.cards.get');
            Route::post('/card-store', 'storeCard')->name('admin.values.card.store');
            Route::get('/card-edit/{id}', 'editCard')->name('admin.values.card.edit');
            Route::post('/card-update/{id}', 'updateCard')->name('admin.values.card.update');
            Route::delete('/card-delete/{id}', 'deleteCard')->name('admin.values.card.delete');
        });        
    });
    /*-----------Stats Section Routes ----------*/
    Route::prefix('admin/stats-section')->group(function () {
        Route::controller(StatController::class)->group(function () {
            Route::get('/', 'index')->name('admin.stats.index');
            Route::get('/get-stats', 'getStats')->name('admin.stats.get');
            Route::post('/store', 'store')->name('admin.stats.store');
            Route::get('/edit/{id}', 'edit')->name('admin.stats.edit');
            Route::post('/update/{id}', 'update')->name('admin.stats.update');
            Route::delete('/delete/{id}', 'delete')->name('admin.stats.delete');
        });        
    });
    /*-----------Features Section Routes ----------*/
    Route::prefix('admin/features-section')->group(function () {
        Route::controller(FeatureController::class)->group(function () {
            Route::get('/', 'index')->name('admin.features.index');
            Route::post('/header-update', 'updateHeader')->name('admin.features.header.update');
            Route::get('/get-items', 'getItems')->name('admin.features.items.get');
            Route::post('/item-store', 'storeItem')->name('admin.features.item.store');
            Route::get('/item-edit/{id}', 'editItem')->name('admin.features.item.edit');
            Route::post('/item-update/{id}', 'updateItem')->name('admin.features.item.update');
            Route::delete('/item-delete/{id}', 'deleteItem')->name('admin.features.item.delete');
        });        
    });
    /*-----------Alt Features Section Routes ----------*/
    Route::prefix('admin/alt-features-section')->group(function () {
        Route::controller(AltFeatureController::class)->group(function () {
            Route::get('/', 'index')->name('admin.alt_features.index');
            Route::post('/header-update', 'updateHeader')->name('admin.alt_features.header.update');
            Route::get('/get-items', 'getItems')->name('admin.alt_features.items.get');
            Route::post('/item-store', 'storeItem')->name('admin.alt_features.item.store');
            Route::get('/item-edit/{id}', 'editItem')->name('admin.alt_features.item.edit');
            Route::post('/item-update/{id}', 'updateItem')->name('admin.alt_features.item.update');
            Route::delete('/item-delete/{id}', 'deleteItem')->name('admin.alt_features.item.delete');
        });        
    });
    /*-----------Services Section Routes ----------*/
    Route::prefix('admin/services-section')->group(function () {
        Route::controller(ServiceController::class)->group(function () {
            Route::get('/', 'index')->name('admin.services.index');
            Route::post('/header-update', 'updateHeader')->name('admin.services.header.update');
            Route::get('/get-items', 'getItems')->name('admin.services.items.get');
            Route::post('/item-store', 'storeItem')->name('admin.services.item.store');
            Route::get('/item-edit/{id}', 'editItem')->name('admin.services.item.edit');
            Route::post('/item-update/{id}', 'updateItem')->name('admin.services.item.update');
            Route::delete('/item-delete/{id}', 'deleteItem')->name('admin.services.item.delete');
        });        
    });
    /*-----------Pricing Section Routes ----------*/
    Route::prefix('admin/pricing-section')->group(function () {
        Route::controller(PricingController::class)->group(function () {
            Route::get('/', 'index')->name('admin.pricing.index');
            Route::post('/header-update', 'updateHeader')->name('admin.pricing.header.update');
            Route::get('/get-plans', 'getPlans')->name('admin.pricing.plans.get');
            Route::post('/plan-store', 'storePlan')->name('admin.pricing.plan.store');
            Route::get('/plan-edit/{id}', 'editPlan')->name('admin.pricing.plan.edit');
            Route::post('/plan-update/{id}', 'updatePlan')->name('admin.pricing.plan.update');
            Route::delete('/plan-delete/{id}', 'deletePlan')->name('admin.pricing.plan.delete');
        });        
    });
    /*-----------FAQ Section Routes ----------*/
    Route::prefix('admin/faq-section')->group(function () {
        Route::controller(FaqController::class)->group(function () {
            Route::get('/', 'index')->name('admin.faq.index');
            Route::post('/header-update', 'updateHeader')->name('admin.faq.header.update');
            Route::get('/get-items', 'getItems')->name('admin.faq.items.get');
            Route::post('/item-store', 'storeItem')->name('admin.faq.item.store');
            Route::get('/item-edit/{id}', 'editItem')->name('admin.faq.item.edit');
            Route::post('/item-update/{id}', 'updateItem')->name('admin.faq.item.update');
            Route::delete('/item-delete/{id}', 'deleteItem')->name('admin.faq.item.delete');
        });        
    });
    /*-----------Testimonials Section Routes ----------*/
    Route::prefix('admin/testimonials-section')->group(function () {
        Route::controller(TestimonialController::class)->group(function () {
            Route::get('/', 'index')->name('admin.testimonials.index');
            Route::post('/header-update', 'updateHeader')->name('admin.testimonials.header.update');
            Route::get('/get-items', 'getItems')->name('admin.testimonials.items.get');
            Route::post('/item-store', 'storeItem')->name('admin.testimonials.item.store');
            Route::get('/item-edit/{id}', 'editItem')->name('admin.testimonials.item.edit');
            Route::post('/item-update/{id}', 'updateItem')->name('admin.testimonials.item.update');
            Route::delete('/item-delete/{id}', 'deleteItem')->name('admin.testimonials.item.delete');
        });        
    });
    /*-----------Team Section Routes----------*/
    Route::prefix('admin/team-section')->group(function () {
        Route::controller(TeamController::class)->group(function () {
            Route::get('/', 'index')->name('admin.team.index');
            Route::post('/header-update', 'updateHeader')->name('admin.team.header.update');
            Route::get('/get-items', 'getItems')->name('admin.team.items.get');
            Route::post('/item-store', 'storeItem')->name('admin.team.item.store');
            Route::get('/item-edit/{id}', 'editItem')->name('admin.team.item.edit');
            Route::post('/item-update/{id}', 'updateItem')->name('admin.team.item.update');
            Route::delete('/item-delete/{id}', 'deleteItem')->name('admin.team.item.delete');
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