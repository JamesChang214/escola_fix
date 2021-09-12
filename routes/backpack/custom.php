<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use App\Http\Controllers\Admin\CenterSwitchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReconciliationTransactionController;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('centre', 'CentreCrudController');
    Route::crud('classer', 'ClasserCrudController');
    Route::crud('classertemplate', 'ClassertemplateCrudController');
    Route::crud('financedocument', 'FinanceDocumentCrudController');
    Route::crud('financedocumentitem', 'FinanceDocumentItemCrudController');
    Route::crud('financereconciliation', 'FinanceReconciliationCrudController');
    Route::crud('grade', 'GradeCrudController');
    Route::crud('guardian', 'GuardianCrudController');
    Route::crud('invoice', 'InvoiceCrudController');
    Route::crud('collection', 'CollectionInvoiceCrudController');
    Route::crud('invoicefeetype', 'InvoiceFeeTypeCrudController');
    Route::crud('invoiceitem', 'InvoiceItemCrudController');
    Route::crud('invoicepayment', 'InvoicePaymentCrudController');
    Route::crud('invoicepaymentvoid', 'InvoicePaymentVoidCrudController');
    Route::crud('link', 'LinkCrudController');
    Route::crud('paymenttype', 'PaymentTypeCrudController');
    Route::crud('period', 'PeriodCrudController');
    Route::crud('profile', 'ProfileCrudController');
    Route::crud('scheduleclasser', 'ScheduleClasserCrudController');
    Route::crud('scheduleteacher', 'ScheduleTeacherCrudController');
    Route::crud('school', 'SchoolCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('tusers', 'TusersCrudController');

    Route::post('make/invoices/payment', 'InvoiceCrudController@bulkInvoicePayments');

    Route::get('search/classes', 'SpecialController@getClassers');
    Route::post('get/grades/subjects', 'SpecialController@getGradesAndSubjects');
    Route::post('get/invoices/payments', 'SpecialController@getInvoicePaymentInputs');

    Route::get('search/fee/types', 'SpecialController@getFeeTypes');
    Route::get('get/invoice/{invoice_id}/pdf/{type}', 'SpecialController@getInvoicePdf');
    
        Route::group(['prefix' => 'reconciliation'], function () {
        Route::get('transactions', [ReconciliationTransactionController::class, 'index'])->name('reconciliation-transaction');
        Route::get('new', [ReconciliationTransactionController::class, 'store'])->name('reconciliation-store');
        Route::get('void', [ReconciliationTransactionController::class, 'storeVoid'])->name('void-store');
    }); 
    
    Route::get('check/invoices/status', 'SpecialController@checkInvoiceStatus');

    Route::get('get/receipt/{payment_id}/pdf', 'SpecialController@getReceiptPdf');
    Route::get('invoice/{invoice_id}/get/fee/type/{fee_type_id}/value', 'SpecialController@getFeeTypeValue');

    Route::crud('financedeposit', 'FinanceDepositCrudController');
    Route::get('dashboard', [DashboardController::class, 'home']);

    Route::group(['prefix' => 'centre-switch'], function () {
        Route::get('home', [CenterSwitchController::class, 'home'])->name('centre-switch');
        Route::get('switch', [CenterSwitchController::class, 'switch'])->name('centre-switch-switch');
        Route::get('switch-default', [CenterSwitchController::class, 'switchDefault'])->name('centre-switch-default');
    });

    Route::post('get/invoices/payment/refund', 'SpecialController@getRefundPaymentInput');
    Route::post('get/invoice/payment/details', 'SpecialController@getInvoicePaymentDetails');
    Route::post('payment/void', 'SpecialController@voidPayment');

    Route::get('attendance', 'AttendanceController@index');
    Route::post('attendance/student', 'AttendanceController@updateStudent');
    Route::post('attendance/classer', 'AttendanceController@updateClasser');
    Route::post('attendance/classer/teacher', 'AttendanceController@updateTeacher');
}); // this should be the absolute last line of this file