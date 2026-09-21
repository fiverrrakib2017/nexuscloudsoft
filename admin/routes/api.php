<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Admin\AdminController;
use App\Http\Controllers\Backend\Api\BkashSmsController;

Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AdminController::class, 'api_login']);

    Route::middleware('auth:sanctum')->group(function () {

        /** Customer Route **/
    Route::prefix('admin/customer')->group(function () {
        Route::controller(\App\Http\Controllers\Backend\Api\CustomerController::class)->group(function () {
            Route::get('/', 'all_customers');
            // Route::get('/edit/{id}', 'edit')->name('admin.customer.edit');
            // Route::get('/view/{id}', 'view')->name('admin.customer.view');
            // Route::post('/delete', 'delete')->name('admin.customer.delete');
            // Route::post('/bulk/delete', 'bulk_customer_delete')->name('admin.customer.bulk.delete');
            // Route::post('/forge_delete', 'forge_delete')->name('admin.customer.forge_delete');
            Route::post('/check-username', 'check_customer_user');
            Route::get('/search', 'customer_search');

            Route::post('/store', 'store');
            Route::post('/update/{id}', 'update');
            Route::post('/change_expire_date', 'customer_change_expire_date');
            Route::post('/change_package', 'customer_change_pacakge');
            Route::post('/bulk-reconnect', 'bulk_customer_re_connect');

            /***** Customer Discountinue *******/
            Route::get('/discountinue/{customer_id}', 'customer_discountinue');
            /***** Customer Recharge *******/
            Route::post('/recharge/store', 'customer_recharge');
            Route::get('/recharge/undo/{id}', 'customer_recharge_undo');
            Route::get('/recharge/print/{id}', 'customer_recharge_print');
            Route::get('/recharge/bulk-recharge', 'customer_bulk_recharge');
            Route::post('/recharge/bulk-recharge-store', 'customer_bulk_recharge_store');
            Route::post('/recharge/grace-recharge-store', 'customer_grace_recharge_store');
            Route::get('/recharge/grace-recharge/remove/{customer_id}', 'customer_grace_recharge_remove');

            /***** Customer comming expire *******/
            Route::get('/comming-expire', 'customer_comming_expire');

            /***** Customer Device expire *******/
            Route::get('/device/return/{id}', 'customer_device_return');

            /***** Customer Payment History *******/
            Route::get('/payment/history', 'customer_payment_history');
            Route::get('/payment/history/get_all_data', 'customer_payment_history_get_all_data');
            Route::get('/bill/generate', 'customer_bill_generate');
            /***** Customer Grace Recharge Logs *******/
            Route::get('/grace-recharge/logs', 'customer_grace_recharge_logs');
            Route::get('/grace-recharge/logs/get_all_data', 'customer_grace_recharge_logs_get_all_data');
            /***** Customer Log *******/
            Route::get('/customer/log', 'customer_log');
            Route::get('/customer/log/get_all_data', 'customer_log_get_all_data');
            /***** Customer Credit Recharge List *******/
            Route::get('/credit/recharge/list', 'customer_credit_recharge_list');
            Route::get('/credit/recharge/get_all_data', 'show_credit_recharge_list_data');
            /***** Customer Backup *******/
            Route::get('/customer/restore', 'customer_restore');
            Route::get('/customer/restore/get_all_data', 'customer_restore_get_all_data');
            Route::post('/customer/restore/back', 'customer_restore_back');
            /***** Customer Import *******/
            Route::get('/import/index', 'customer_import');
            Route::post('/import/store', 'customer_csv_file_import');
            Route::get('/delete-csv-file/{file}', [CustomerController::class, 'delete_csv_file']);
            Route::get('/upload/csv-file', [CustomerController::class, 'upload_csv_file']);
            Route::get('/import/mikrotik', 'customer_import_from_mikrotik');
            Route::post('/import/mikrotik/store', 'customer_import_from_mikrotik_store');
            /***** Customer Mikrotik Re-connect *******/
            Route::get('/mikrotik/reconnect/{customer_id}', 'customer_mikrotik_reconnect');
            /***** Customer Change Status *******/
            Route::post('/change/status', 'customer_change_status');
             /*****Get Router name *******/
             Route::post('/get_router_name', 'get_router_name');
        });
    });
    Route::post('admin/logout', [AdminController::class, 'api_logout']);
    });

    /*auto bkash send money customer recharge route*/
    Route::post('bkash/sms-receiver', [BkashSmsController::class, 'receive']);
});
