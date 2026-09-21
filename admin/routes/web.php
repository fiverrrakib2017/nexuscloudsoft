<?php

use App\Http\Controllers\Backend\Accounts\Account_controller;
use App\Http\Controllers\Backend\Accounts\Balance_sheet_controller;
use App\Http\Controllers\Backend\Accounts\Income_controller;
use App\Http\Controllers\Backend\Accounts\Ledger_controller;
use App\Http\Controllers\Backend\Accounts\Transaction_controller;
use App\Http\Controllers\Backend\Accounts\Trial_balance_controller;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Admin\LoginLogController;
use App\Http\Controllers\Backend\Client\Client_invoiceController;
use App\Http\Controllers\Backend\Customer\CustomerController;
use App\Http\Controllers\Backend\Customer\RequestController;
use App\Http\Controllers\Backend\Supplier\Supplier_invoiceController;
use App\Http\Controllers\Backend\Supplier\Supplier_returnController;
use App\Http\Controllers\Backend\Customer\InvoiceController;
use App\Http\Controllers\Backend\Customer\PackageController;
use App\Http\Controllers\Backend\Customer\PoolController;
use App\Http\Controllers\Backend\Customer\TicketController;
use App\Http\Controllers\Backend\Pop\PopController;
use App\Http\Controllers\Backend\Pop\Area\AreaController;
use App\Http\Controllers\Backend\Product\BrandController;
use App\Http\Controllers\Backend\Product\CategoryController;
use App\Http\Controllers\Backend\Product\SubCateogryController;
use App\Http\Controllers\Backend\Product\ColorController;
use App\Http\Controllers\Backend\Product\ProductController;
use App\Http\Controllers\Backend\Product\TempImageController;
use App\Http\Controllers\Backend\Product\ChildCategoryController;
use App\Http\Controllers\Backend\Product\SizeController;
use App\Http\Controllers\Backend\Product\StockController;
use App\Http\Controllers\Backend\Product\StoreController;
use App\Http\Controllers\Backend\Product\UnitController;
use App\Http\Controllers\Backend\Router\RouterController;
use App\Http\Controllers\Backend\Settings\Others\SettingsController;
use App\Http\Controllers\Backend\Sms\SmsController;
use App\Http\Controllers\Backend\Client\ClientController;
use App\Http\Controllers\Backend\Hrm\Attendance_controller;
use App\Http\Controllers\Backend\Hrm\Department_controller;
use App\Http\Controllers\Backend\Hrm\Designation_controller;
use App\Http\Controllers\Backend\Hrm\Employee_controller;
use App\Http\Controllers\Backend\Hrm\Leave_controller;
use App\Http\Controllers\Backend\Hrm\Loan_controller;
use App\Http\Controllers\Backend\Hrm\Payroll_controller;
use App\Http\Controllers\Backend\Hrm\Salary_controller;
use App\Http\Controllers\Backend\Supplier\SupplierController;
use App\Http\Controllers\Backend\Tickets\Assign_controller;
use App\Http\Controllers\Backend\Tickets\ReportController;
use App\Http\Controllers\Backend\Tickets\Complain_typeController;
use App\Http\Controllers\Backend\Hrm\Shift_controller;
use App\Http\Controllers\Backend\Olt\Olt_controller;
use App\Http\Controllers\Backend\Onu\Onu_controller;
use App\Http\Controllers\Backend\Tickets\Ticket_controller;
use App\Http\Controllers\Backend\Admin\UserController;
use App\Http\Controllers\Backend\Role\RoleController;
use App\Http\Controllers\Backend\Permission\PermissionController;
use App\Http\Controllers\Backend\Tenant\TenantController;
use App\Models\Product_Category;
use App\Models\Router;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Broadcast;
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


    /** User Management  Route **/
    Route::prefix('admin/user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/list', 'index')->name('admin.user.index')->middleware('permission:manage.user.list,admin');
            Route::get('/get_user/{id}', 'get_user')->name('admin.user.get_user');
            Route::post('/store', 'store')->name('admin.user.store');
            Route::post('/update', 'update')->name('admin.user.update')->middleware('permission:manage.user.edit,admin');
            Route::post('/delete', 'delete')->name('admin.user.delete')->middleware('permission:manage.user.delete,admin');
        });
        /*---------Users login Log----------*/
        Route::controller(LoginLogController::class)->group(function () {
            Route::get('/logs', 'index')->name('admin.user.logs.index')->middleware('permission:manage.user.logs.list,admin');
            Route::get('/get_data', 'get_data')->name('admin.user.logs.get_data');
            Route::post('/logs/delete', 'delete')->name('admin.user.logs.delete')->middleware('permission:manage.user.logs.delete,admin');
        });
        
    });
});
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return 'Optimize Clear Completed';
});

