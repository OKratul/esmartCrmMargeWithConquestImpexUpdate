<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddProductController;
use App\Http\Controllers\AddWebsiteDataController;
use App\Http\Controllers\AdminCalendarController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminInvoiceController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminMailController;
use App\Http\Controllers\AdminQueryController;
use App\Http\Controllers\AdminQuotationController;
use App\Http\Controllers\AdminUserProfile;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\conquest\ConquestAccountController;
use App\Http\Controllers\conquest\ConquestCustomersController;
use App\Http\Controllers\conquest\ConquestDashboardController;
use App\Http\Controllers\conquest\ConquestExpenseController;
use App\Http\Controllers\conquest\ConquestInvoiceController;
use App\Http\Controllers\conquest\ConquestPaymentController;
use App\Http\Controllers\conquest\ConquestProductController;
use App\Http\Controllers\conquest\ConquestTransectionController;
use App\Http\Controllers\CustomerAddController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceExportExcelController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\MakeUserFromOldDatabase;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OldDataController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhoneNumbersController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\QueryStatusChange;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportExport;
use App\Http\Controllers\ReqForTransferontroller;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SmsSentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UpdateInvoiceStatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserStaffAddController;
use App\Http\Controllers\WoocommerceController;
use App\Models\conquest\ConquestProduct;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromotionMialController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',[UserLoginController::class,'login']);

//=== Admin Login Route ====
Route::get('admin-login',[AdminLoginController::class,'index'])->name('show-login')->middleware('ip-restriction');
Route::post('get-login-data',[AdminLoginController::class,'login'])->name('admin-login'
)->middleware('ip-restriction');

//=== User Login Route ====
Route::get('user-login',[UserLoginController::class,'showLogin'])->name('user-login')->middleware('ip-restriction');
Route::post('login',[UserLoginController::class,'login'])->name('user-login-done')->middleware('ip-restriction');



//================ Admin Route Group =======================

Route::group(['middleware'=>'adminAuth'],function (){

    Route::get('promotion/mail/all-customers',[PromotionMialController::class,'promotionMail'])->name('promotion-mail');

    Route::get('admin/dashboard',[AdminDashboardController::class,'dashboard'])->name('dashboard');
    Route::get('admin/add-user',[UserStaffAddController::class,'index'])->name('add-user');

    Route::get('crm/links',[AdminLoginController::class,'crmLinks'])->name('crm-links');

    Route::post('register-user',[UserController::class,'registerUser'])->name('register-user');

    Route::get('admin/add-user-profile/{id}',[UserProfileController::class,'addProfile'])->name('add-user-profile');
    Route::post('admin/add-user-profile/{id}',[UserProfileController::class,'profile'])->name('profile-added');

    Route::get('admin/add-website-data',[AddWebsiteDataController::class,'viewForm'])->name('add-website');
    Route::post('admin/add-website-data/added',[AddWebsiteDataController::class,'addSiteData'])->name('site-added');

    Route::get('admin/all-products',[AddWebsiteDataController::class,'getdata'])->name('products');

//Wordpress Route

    Route::get('admin/esmart/products',[WoocommerceController::class,'products'])->name('woocommerce-products');

    Route::get('admin/users/attendance',[AttendanceController::class,'attendance'])->name('attendance');

//    ==================== Admin options & Profile Update ====================

    Route::get('admin/settings',[SettingsController::class,'index'])->name('admin-settings');
    Route::post('admin/profile/update',[SettingsController::class,'adminProfile'])->name('admin-profile-update');

    Route::get('admin/options',[SettingsController::class,'optionsView'])->name('view-admin-options');
    Route::post('admin/options',[SettingsController::class,'unitAdd'])->name('add-unit-options');
    Route::post('admin/options/query-source',[SettingsController::class,'querySourceAdd'])->name('add-querySource-options');
    Route::post('admin/options/query-status',[SettingsController::class,'queryStatusAdd'])->name('add-queryStatus-options');
    Route::post('admin/options/delivery-term',[SettingsController::class,'deliveryTermAdd'])->name('add-deliveryTerm-options');
    Route::post('admin/options/payment-type',[SettingsController::class,'paymentTypeAdd'])->name('add-paymentType-options');
    Route::post('admin/options/warranty',[SettingsController::class,'warrantyAdd'])->name('warranty');
    Route::post('admin/options/add-expense',[SettingsController::class,'addExpense'])->name('add-expense');

// ======== All Query =======

    Route::get('admin/all-query',[AdminQueryController::class,'allQuery'])->name('admin-all-query');

    Route::get('admin/query-pagination',[AdminDashboardController::class,'queries'])->name('
    ');

//   ============= All Quotation ==========

    Route::get('admin/all-quotation',[AdminQuotationController::class,'allQuotation'])->name('admin-all-quotation');


//========= Assign Task ==========
    Route::post('assign-task-to-user',[AdminDashboardController::class,'assignTask'])->name('assign-task');
    Route::get('admin/task-approve/{id}',[AdminDashboardController::class,'approveTask'])->name('task-approve');
    Route::get('admin/task-failed/{id}',[AdminDashboardController::class,'jobFailed'])->name('task-failed');


//    ============Admin User Profile Route ==========

    Route::get('admin/user-profile/{id}',[AdminUserProfile::class,'userDetails'])->name('admin-user-profile');
    Route::get('admin/user-profile/{id}/add-mail',[AdminUserProfile::class,'viewAddMail'])->name('add-mail-user');
    Route::post('admin/user-profile/{id}/add-mail',[AdminUserProfile::class,'addMailToUser'])->name('add-mail-to-user');
    Route::get('admin/user-profile/{id}/update-mail/{email_id}',[AdminUserProfile::class,'viewEditEmail'])->name('view-edit-email');
    Route::post('admin/user-profile/{id}/update-mail/{mail_id}',[AdminUserProfile::class,'updateEmailAccount'])->name('update-email-config');

//=============Admin Invoice =========

    Route::get('admin/generate-new-invoice',[InvoiceController::class,'viewInvoiceGenerator'])->name('admin-view-new-invoice-generator');
    Route::post('admin/generate-new-invoice',[InvoiceController::class,'newInvoice'])->name('admin-new-generator');

    Route::get('admin/customer/profile/{id}/all-invoice/{invoice_id}/edit-Invoice/{index_id}',[CustomerProfileController::class,'removeSingleProductInvoice'])->name('admin-remove-single-product');


//    =======Customers Profile Route =====

    Route::get('all-customers',[CustomerProfileController::class,'viewCustomers'])->name('all-customers');
    Route::get('customer/profile/{id}',[CustomerProfileController::class,'customerProfile'])->name('customer-profile');

    Route::get('add-customer',[CustomerAddController::class,'index'])->name('addCustomer');
    Route::post('customer/added',[CustomerAddController::class,'addCustomer'])->name('customer-added');
    Route::post('customer/update/{id}',[CustomerProfileController::class,'updateCustomer'])->name('customer-update');

    Route::get('customer/profile/{id}/all-query',[CustomerProfileController::class,'viewAllQuery'])->name('view-all-query');
    Route::get('customer/profile/{id}/add-query',[CustomerProfileController::class,'viewQueryForm'])->name('view-add-query-form');
    Route::post('customer/profile/{id}/add-query',[CustomerProfileController::class,'addQuery'])->name('add-query-profile');

    Route::get('customer/profile/{id}/add-quotation',[CustomerProfileController::class,'viewQuotationForm'])->name('view-quotation');
    Route::post('customer/profile/{id}/add-quotation',[CustomerProfileController::class,'addQuotation'])->name('quotation-add-profile');

    Route::get('customer/profile/{id}/all-quotations',[CustomerProfileController::class,'allQuotations'])->name('customer-all-quotations');
    Route::get('customer/profile/{id}/edit-quotation/{quotation_id}',[CustomerProfileController::class,'viewEditQuotation'])->name('view-edite-quotation-from-profile');
    Route::post('customer/profile/{id}/edit-quotation/{quotation_id}',[CustomerProfileController::class,'editQuotation'])->name('edit-quotation');
    Route::get('customer/profile/{id}/quotation/{quotation_id}/delete/',[CustomerProfileController::class,'deleteQuotation'])->name('delete-quotation');

    Route::get('admin/customer/profile/{id}/quotation/all-invoice',[CustomerProfileController::class,'allInvoice'])->name('admin-customer-all-invoice');

    Route::get('admin/customer/{customer_id}/profile/{query_id}',[CustomerProfileController::class,'showEditQuery'])->name('admin-customer-show-edit-query');


    Route::get('admin/customer/profile/{id}/notes',[CustomerProfileController::class,'notes'])->name('admin-customer-notes');
    Route::post('admin/customer/profile/{id}/notes',[CustomerProfileController::class,'addNotes'])->name('admin-customer-add-notes');
    Route::post('admin/customer/profile/{note_id}/update',[CustomerProfileController::class,'updateNote'])->name('admin-update-note');


//    ==========Admin Query Route =======

    Route::get('query/form',[QueryController::class,'viewQueryForm'])->name('view-query-form');

    Route::post('query-request',[AdminDashboardController::class,'queryRequest'])->name('query-request');
    Route::post('query/{query_id}/assign',[AdminDashboardController::class,'assignQuery'])->name('assign_query');

//    ======= Query Change Status =========

    Route::get('query-status/{query_id}/processing',[QueryStatusChange::class,'processing'])->name('status-processing');
    Route::get('query-status/{query_id}/quotationSent',[QueryStatusChange::class,'quotationSent'])->name('status-quotationSent');
    Route::get('query-status/{query_id}/orderConfirmed',[QueryStatusChange::class,'orderConfirmed'])->name('order-confirmed');
    Route::get('query-status/{query_id}/deliveryOnGoing',[QueryStatusChange::class,'deliveryOnGoing'])->name('delivery-on-going');
    Route::get('query-status/{query_id}/delivered',[QueryStatusChange::class,'delivered'])->name('delivered');
    Route::get('query-status/{query_id}/closed',[QueryStatusChange::class,'closed'])->name('closed');



//    ===== Add notes =====

    Route::post('customer/profile/{id}/all-query/{query_id}/add-note',[CustomerProfileController::class,'addNote'])->name('admin-add-note');
    Route::get('customer/profile/{id}/all-query/{query_id}/delete-note/{note_id}',[CustomerProfileController::class,'deleteNote'])->name('admin-delete-note');

    Route::get('admin/customer/profile/all-query/delete-note/{note_id}',[CustomerProfileController::class,'deleteNote'])->name('admin-delete-note');


//    ======= Quotation ====

    Route::get('admin/quotation/add-quotation',[QuotationController::class,'viewQuotationForm'])->name('admin-view-quotation-form');
    Route::post('quotation/add-quotation',[QuotationController::class,'quotation'])->name('quotation');
    Route::get('admin/quotation/{id}/show-edit-quotation',[AdminQuotationController::class,'showEditQuotation'])->name('admin-show-edit-quotation');
    Route::post('admin/quotation/{id}/show-edit-quotation',[AdminQuotationController::class,'updateQuotation'])->name('admin-update-quotation');

    Route::get('admin/customer/profile/{id}/quotation/{quotation_id}/view-quotation',[CustomerProfileController::class,'viewQuotation'])->name('admin-view-quotation-pdf');
    Route::get('admin/customer/profile/{id}/quotation/{quotation_id}/delete',[CustomerProfileController::class,'deleteQuotation'])->name('admin-delete-quotation');

    Route::get('admin/customer/profile/{id}/quotation/{quotation_id}/view-invoice-generator',[CustomerProfileController::class,'viewInvoiceGenerator'])->name('admin-view-invoice-generator');

    Route::get('admin/customer/profile/{id}/quotation/{quotation_id}/mail',[CustomerProfileController::class,'sentQuotationMail'])->name('admin-sent-quotation-mail');


    Route::get('admin/customer/profile/{id}/add-quotation',[CustomerProfileController::class,'viewQuotationForm'])->name('admin-view-add-quotation');
    Route::post('admin/customer/profile/{customer_id}/add-quotation',[CustomerProfileController::class,'addQuotation'])->name('admin-quotation-add-profile');

    Route::get('admin/customer/profile/{id}/edit-quotation/{quotation_id}/delete-product/{product_index}',[CustomerProfileController::class,'deleteSingleProductQuotation'])->name('admin-delete-single-product');

    Route::get('admin/quotation/{id}/history',[QuotationController::class,'quotationHistory'])->name('quotation-history');

//    ======Customer Profile Invoice =====

    Route::get('admin/all-invoice',[AdminInvoiceController::class,'allInvoice'])->name('admin-all-invoice');

    Route::get('admin/customer/profile/{id}/make-invoice',[CustomerProfileController::class,'viewGenerateNewInvoice'])->name('admin-view-generate-new-invoice');
    Route::post('admin/customer/profile/{id}/make-invoice',[CustomerProfileController::class,'generateNewInvoice'])->name('admin-generate-new-invoice');

    Route::get('admin/customer/profile/{id}/all-invoice/{invoice_id}/edit-Invoice',[CustomerProfileController::class,'viewEditInvoice'])->name('admin-view-edit-invoice');

    Route::get('admin/customer/profile/{id}/all-invoice/{invoice_id}/delete-Invoice',[CustomerProfileController::class,'deleteInvoice'])->name('admin-delete-invoice');

    Route::get('admin/customer/profile/{id}/all-invoice/{invoice_id}/view-invoice-pdf',[CustomerProfileController::class,'viewInvoicePdf'])->name('admin-view-invoice-pdf');

    Route::get('admin/customer/all-invoice/download-invoice/{invoice_id}',[CustomerProfileController::class,'downloadInvoicePdf'])->name('admin-download-invoice');

    Route::get('admin/all-invoice/{invoice_id}/sent-mail',[InvoiceController::class,'invoiceMail'])->name('admin-invoice-mail');

    Route::get('admin/all-invoice/{invoice_id}/challan',[InvoiceController::class,'challan'])->name('admin-challan');

    Route::get('admin/all-invoice/{invoice_id}/money-receipt',[InvoiceController::class,'moneyReceipt'])->name('admin-money-receipt');

    Route::get('admin/add/payment/{invoice_id}/from-all-invoice/',[PaymentController::class,'showPayment'])->name('admin-show-add-payment-from-all-invoice');

    Route::post('admin/add/payment/{customer_id}/from-all-invoice/{invoice_id}',[PaymentController::class,'addPayment'])->name('admin-add-payment-from-all-invoice');

//    payment
    Route::get('admin/customer/profile/{id}/all-payment',[CustomerProfileController::class,'allPayments'])->name('admin-customer-all-payment');
    Route::get('admin/all-payments',[PaymentController::class,'allPayment'])->name('admin-all-payments');

    Route::get('admin/customer/profile/{id}/invoice/{invoice_id}/make-payment',[CustomerProfileController::class,'viewAddPaymentForm'])->name('admin-make-payment');
    Route::post('admin/customer/profile/{id}/invoice/make-payment/{invoice_id}',[CustomerProfileController::class,'addPaymentFromInvoice'])->name('admin-direct-add-payment');


//    Phone Number

    Route::get('admin/phone-numbers',[PhoneNumbersController::class,'index'])->name('phone-numbers');
    Route::post('admin/phone-numbers',[PhoneNumbersController::class,'addPhoneNumber'])->name('add-phonebook');

//    Documents

    Route::get('admin/documents',[DocumentsController::class,'index'])->name('documents');
    Route::post('admin/documents',[DocumentsController::class,'uploadFile'])->name('document-upload');

    Route::get('admin/delete-document/{id}',[DocumentsController::class,'deleteDocument'])->name('admin-delete-document');
    Route::get('admin/document-download/{id}',[DocumentsController::class,'downloadDocument'])->name('admin-download-document');

//   =============== Admin Query ==========

    Route::get('admin/{query_id}/update-query',[QueryController::class,'showUpdateQuery'])->name('admin-showUpdateQuery');
    Route::post('admin/{query_id}/update-query',[QueryController::class,'updateQuery'])->name('admin-updateQuery');
    Route::get('admin/{query_id}/delete',[QueryController::class,'deleteQuery'])->name('admin-deleteQuery');
    Route::post('admin/query-with-customer',[QueryController::class,'queryWithCustomer'])->name('admin-add-query-with-customer');

    Route::post('admin/{query_id}/update-query',[QueryController::class,'updateQuery'])->name('admin-updateQuery');
    Route::get('admin/{query_id}/delete',[QueryController::class,'deleteQuery'])->name('admin-deleteQuery');

    Route::post('admin/customer/profile/{id}/all-invoice/{invoice_id}/edit-Invoice',[CustomerProfileController::class,'updateInvoice'])->name('admin-update-invoice');

    Route::get('admin/{query_id}/transfer-query/{req_id}/{id}',[ReqForTransferontroller::class,'approveReq'])->name('admin-approve-req');
    Route::get('admin/query-transfer-request/decline/{id}',[ReqForTransferontroller::class,'declineReq'])->name('admin-decline-req');

//   ================ Admin Mail ===============

    Route::get('admin/mail-box',[AdminMailController::class,'index'])->name('admin-mailbox');
    Route::post('admin/add-mail',[AdminMailController::class,'addAccount'])->name('admin-mail-add');

    Route::get('admin/mail-edit/{id}',[AdminMailController::class,'showEditMailAcc'])->name('admin-mail-edit');
    Route::post('admin/update-mail-acc/{id}',[AdminMailController::class,'updateMailAcc'])->name('update-mail-acc');

    Route::get('admin/delete-mail-acc/{id}',[AdminMailController::class,'deleteMailAcc'])->name('admin-delete-mail');

    Route::get('admin/mail-folders/{id}',[AdminMailController::class,'mailFolders'])->name('admin-mail-folders');

    Route::get('admin/view-single-mail/{mail_id}/{mid}',[AdminMailController::class,'viewSingleMail'])->name('admin-view-single-mail');

    Route::get('admin/mail/accounts/{mail_id}/mail-folders/mail-replay/{uid}/',[AdminMailController::class,'mailRepaly'])->name('admin-mail-replay');

    Route::post('admin/mail/accounts/{mail_id}/mail-folders/mail-replay/{uid}/',[AdminMailController::class,'sendReplay'])->name('admin-send-replay');

    //    ================ Admin Calendar ===========

    Route::get('admin/calendar',[AdminCalendarController::class,'showCalendar'])->name('admin-calendar');
    Route::post('admin/calendar',[AdminCalendarController::class,'addEvent'])->name('admin-calendar-add');

    Route::put('admin/update-calendar/{id}',[AdminCalendarController::class,'updateEvent'])->name('admin-calendar-update');
    Route::get('admin/delete-calendar-event/{id}',[AdminCalendarController::class,'deleteEvent'])->name('admin-calendar-delete');

// ======== Accounts/Transactions ===========
    Route::get('admin/accounts',[AccountController::class,'index'])->name('accounts');

    Route::post('admin/accounts/add-new',[AccountController::class,'addAccount'])->name('add-accounts');

    Route::get('admin/add-expanses',[ExpensesController::class,'viewAddExpanses'])->name('admin-view-add-expanses');
    Route::post('admin/add-expanses',[ExpensesController::class,'addExpanses'])->name('admin-add-expanses');

    Route::post('admin/cash-in/{account_id}',[TransactionController::class,'cashIn'])->name('admin_cash_in');
    Route::post('admin/cash-out/{account_id}',[TransactionController::class,'cashOut'])->name('admin_cash_out');

    Route::get('admin/all-transactions/{id}',[TransactionController::class,'showTransaction'])->name('view-transactions');


//    ============= Expanses ==========
    Route::get('admin/add-expanses/{invoice_id}',[ExpensesController::class,'viewAddExpanseWithInvoice'])->name('admin-view-add-expanse-invoice');
    Route::post('admin/add-expanses/{invoice_id}',[ExpensesController::class,'addExpanseWithInvoice'])->name('admin-add-expanse-invoice');

// ==============money Receipt ============

    Route::get('admin/all-payments/{id}/money-rec',[PaymentController::class,'moneyRec'])->name('admin-single-money_rec');

    Route::post('admin/invoice/{invoice_id}/sent-sms',[SmsSentController::class,'sentSms'])->name('sent-sms');

    //    =====Logout====
    Route::get('admin/logout',[AdminLoginController::class,'logout'])->name('admin-logout');



//    Admin Export Report
    Route::get('admin/export/queries/',[ReportExport::class,'exportQuery'])->name('admin-query-export');
    Route::get('admin/export/quotation/',[ReportExport::class,'quotationExport'])->name('admin-quotation-export');
    Route::get('admin/export/invoice/',[ReportExport::class,'invoiceExport'])->name('admin-invoice-export');







//  =========================================== Conquest Admin Route ============================================



    Route::prefix('conquest-impex')->group(function (){

        Route::get('/dashboard',[ConquestDashboardController::class,'index'])->name('conquest-dashboard');

//        ==== Conquest Customers Route ====
        Route::get('/customers',[ConquestCustomersController::class,'allCustomers'])->name('conquest-all-customer');
        Route::post('/customer/add',[ConquestCustomersController::class,'addCustomer'])->name('conquest-add-customer');
        Route::post('/customer/{id}/update-info',[ConquestCustomersController::class,'updateInfo'])->name('conquest-update-customer-info');
        Route::get('/customer/{id}/delete',[ConquestCustomersController::class,'deleteCustomer'])->name('conquest-customer-delete');
        Route::get('/customer/{id}/profile',[ConquestCustomersController::class,'customerProfile'])->name('conquest-customer-profile');

        Route::any('/insert/customer-old-data',[ConquestCustomersController::class,'insertOldCustomer']);


//     =======   Conquest Products Route =======

        Route::get('/products',[ConquestProductController::class,'allProduct'])->name('conquest-all-products');
        Route::post('/add-new-product',[ConquestProductController::class,'addProduct'])->name('conquest-add-product');

        Route::post('/update/{id}/product',[ConquestProductController::class,'updateProduct'])->name('conquest-update-product');

        Route::post('/update-stock/{id}',[ConquestProductController::class,'updateStock'])->name('conquest-stock-update');

        Route::get('/update-product/Stock',[ConquestProductController::class,'updateOldStock'])->name('conquest-update-product-stock');
        Route::get('/update-customer',[ConquestProductController::class,'updateCustomersFromOldData'])->name('conquest-update-customer');

        Route::get('/delete/{id}/product',[ConquestProductController::class,'deleteProduct'])->name('conquest-delete-product');

        Route::any('/insert/old-product', [ConquestProductController::class, 'insertOldProduct']);

//        Conquest Invoice Route =====

        Route::get('/all-invoices',[ConquestInvoiceController::class,'allInvoice'])->name('conquest-all-invoices');
        Route::post('/make-invoice',[ConquestInvoiceController::class,'makeInvoice'])->name('conquest-make-invoice');
        Route::get('view-invoice/{id}',[ConquestInvoiceController::class,'viewInvoice'])->name('conquest-view-invoice');
        Route::post('/invoice/{id}/edit-invoice',[ConquestInvoiceController::class,'editInvoice'])->name('conquest-edit-invoice');

        Route::get('/delete/{id}/invoice',[ConquestInvoiceController::class,'deleteInvoice'])->name('conquest-delete-invoice');

        Route::get('/challan/{id}/pdf',[ConquestInvoiceController::class,'challan'])->name('conquest-challan');

        Route::get('/money-receipt/{id}',[ConquestInvoiceController::class,'moneyReceipt'])->name('conquest-money-receipt');



//========= Conquest Payment Route =========

        Route::get('/all-payments',[ConquestPaymentController::class,'allPayments'])->name('conquest-payments');
        Route::post('/add-payment',[ConquestPaymentController::class,'addPayment'])->name('conquest-add-payment');
        Route::get('/update-invoice-id',[ConquestPaymentController::class,'updateInvoiceId'])->name('conquest-update-invoice-id');

        Route::post('/add-payment/form-invoice',[ConquestPaymentController::class,'addPaymentFromInvoice'])->name('conquest-add-payment-invoice');


        Route::get('/update-old-payment',[ConquestPaymentController::class,'updatePaymentFromOld'])->name('conquest-update-old-payment');

        //    ======= Transections ============
        Route::get('/all-trancestions/{id}',[ConquestTransectionController::class,'trancestions'])->name('conquest-trancestions');

//    ========== Expense =====

        Route::get('/all-Expense',[ConquestExpenseController::class,'expenses'])->name('conquest-all-expense');

//    ========== Accounts ===========

        Route::get('/accounts',[ConquestAccountController::class,'accounts'])->name('conquest-accounts');
        Route::post('/account/add',[ConquestAccountController::class,'addAccount'])->name('conquest-account-add');


//    Add Invoice From Old Data

        Route::get('/add-invoice-from-old-data',[ConquestInvoiceController::class,'addInvoiceFromOldData'])->name('conquest-add-old-invoice-data');


//        Excel Report





    });


//    Export Excel Route
    Route::get('export/invoice-data',[InvoiceExportExcelController::class,'invoiceExport'])->name('export-invoice-data');
    Route::get('export/queries-data',[InvoiceExportExcelController::class,'queryExport'])->name('export-all-queries');
    Route::get('export/quotation-data',[InvoiceExportExcelController::class,'quotationExport'])->name('export-all-quotations');
    Route::get('export/company-data',[InvoiceExportExcelController::class,'companyData'])->name('company-data');

});

// ======== user verification ========

Route::get('userverification/{email}/{code}',[UserController::class,'userVerification'])->name('user-verification');




//======= User Route Group =======

Route::group(['middleware'=> 'userAuth'],function (){

    Route::get('user-dashboard',[UserDashboardController::class,'index'])->name('user-dashboard');
    Route::get('user/profile',[UserProfileController::class,'viewProfile'])->name('user-profile');
    Route::post('user/add-user-profile/{id}',[UserProfileController::class,'profile'])->name('user-profile-added');

//    ============ Aut User All query ===========
    Route::get('my-queries',[QueryController::class,'viewUserAllQuery'])->name('my-queries');


//    =============== Products And Categories ================
    Route::get('user/all-products',[AddWebsiteDataController::class,'getdata'])->name('user-all-products');

//    Route::get('user/product/add-products',[AddProductController::class,'productForm'])->name('user-add-products');
//    Route::post('user/product/add-products',[AddProductController::class,'addProduct'])->name('user-product-added');

//    Route::get('user/product/category',[ProductCategoryController::class,'category'])->name('user-product-category');
//    Route::post('user/product/category',[ProductCategoryController::class,'category'])->name('user-search-category');

    Route::get('user/profile/{id}/edit',[UserProfileController::class,'editProfile'])->name('view-profile-edit');

//    ========== Quotations ======

    Route::get('user/quotation/search',[QuotationController::class,'allQuotation'])->name('user-quotation-search');

    Route::get('quotation/all-quotation',[QuotationController::class,'allQuotation'])->name('user-view-all-quotation');
    Route::get('user/quotation/add-quotation',[QuotationController::class,'viewQuotationForm'])->name('user-view-quotation-form');
    Route::post('user/quotation/add-quotation',[QuotationController::class,'quotation'])->name('user-quotation');

    Route::get('user/quotation/{id}/show-edit-quotation',[QuotationController::class,'showEditQuotation'])->name('user-show-edit-quotation');
    Route::post('user/quotation/{id}/show-edit-quotation',[QuotationController::class,'updateQuotation'])->name('user-update-quotation');


    Route::get('user/add-customer',[CustomerAddController::class,'index'])->name('user-addCustomer');
    Route::post('user/add-customer',[CustomerAddController::class,'addCustomer'])->name('user-addCustomer-done');


    Route::get('user/customer/profile/{id}/add-quotation',[CustomerProfileController::class,'viewQuotationForm'])->name('user-view-add-quotation');
    Route::post('user/customer/profile/{customer_id}/add-quotation',[CustomerProfileController::class,'addQuotation'])->name('user-quotation-add-profile');

    Route::get('user/customer/profile/{id}/all-quotations',[CustomerProfileController::class,'allQuotations'])->name('user-customer-all-quotations');

    Route::get('user/customer/profile/{id}/edit-quotation/{quotation_id}',[CustomerProfileController::class,'viewEditQuotation'])->name('user-view-edite-quotation-from-profile');
    Route::post('user/customer/profile/{id}/edit-quotation/{quotation_id}',[CustomerProfileController::class,'editQuotation'])->name('user-customer-edit-quotation');

    Route::get('user/customer/profile/{id}/edit-quotation/{quotation_id}/delete-product/{product_index}',[CustomerProfileController::class,'deleteSingleProductQuotation'])->name('delete-single-product');
    Route::get('user/customer/profile/{id}/quotation/{quotation_id}/delete',[CustomerProfileController::class,'deleteQuotation'])->name('user-delete-quotation');

// =========== Query Status ===========
    Route::get('user/query-status/{query_id}/processing',[QueryStatusChange::class,'processing'])->name('user-status-processing');
    Route::get('user/query-status/{query_id}/quotationSent',[QueryStatusChange::class,'quotationSent'])->name('user-status-quotationSent');
    Route::get('user/query-status/{query_id}/orderConfirmed',[QueryStatusChange::class,'orderConfirmed'])->name('user-order-confirmed');
    Route::get('user/query-status/{query_id}/deliveryOnGoing',[QueryStatusChange::class,'deliveryOnGoing'])->name('user-delivery-on-going');
    Route::get('user/query-status/{query_id}/delivered',[QueryStatusChange::class,'delivered'])->name('user-delivered');
    Route::get('user/query-status/{query_id}/closed',[QueryStatusChange::class,'closed'])->name('user-closed');


//    ==========Task Undone =========

    Route::get('user/task-undone/{id}',[UserDashboardController::class,'taskUndo'])->name('task-undone');

    //    =======Customers Profile Route =====

    Route::get('user-all-Customers/search',[CustomerProfileController::class,'viewCustomers'])->name('user-all-customer-search');

    Route::get('user-customers',[CustomerProfileController::class,'viewCustomers'])->name('user-customers');
    Route::get('user/customer/profile/{id}',[CustomerProfileController::class,'customerProfile'])->name('user-customer-profile');

    Route::get('user/add-customer',[CustomerAddController::class,'index'])->name('user-addCustomer');
    Route::post('user/customer/added',[CustomerAddController::class,'addCustomer'])->name('user-customer-added');
    Route::post('user-customer/update/{id}',[CustomerProfileController::class,'updateCustomer'])->name('user-customer-update');

    Route::get('user/customer/profile/{id}/notes',[CustomerProfileController::class,'notes'])->name('user-customer-notes');
    Route::post('user/customer/profile/{id}/notes',[CustomerProfileController::class,'addNotes'])->name('user-customer-add-notes');


//    =========== Query =========

    Route::get('user/query-search',[QueryController::class,'allQuery'])->name('user-query-search');
    Route::get('user/query/date-filter',[QueryController::class,'allQuery'])->name('user-query-date-filter');

    Route::get('user/query-form',[QueryController::class,'viewQueryForm'])->name('user-view-query-form');
    Route::post('user/query-add',[QueryController::class,'addQuery'])->name('user-add-query');
    Route::post('user/query-with-customer',[QueryController::class,'queryWithCustomer'])->name('add-query-with-customer');

    Route::get('user/all-query',[QueryController::class,'allQuery'])->name('all-query');
    Route::get('user/customer/profile/{id}/all-query',[CustomerProfileController::class,'viewAllQuery'])->name('user-view-all-query');
    Route::get('user/customer/profile/{id}/add-query',[CustomerProfileController::class,'viewQueryForm'])->name('user-query-add-form-profile');
    Route::post('user/customer/profile/{id}/add-query',[CustomerProfileController::class,'addQuery'])->name('user-add-query-profile');

    Route::get('user/customer/{customer_id}/profile/{query_id}',[CustomerProfileController::class,'showEditQuery'])->name('user-customer-show-edit-query');

    Route::post('user/customer/profile/{id}/all-query/{query_id}/add-note',[CustomerProfileController::class,'addNote'])->name('add-note');
    Route::post('user/customer/profile/{note_id}/update',[CustomerProfileController::class,'updateNote'])->name('user-update-note');
    Route::get('user/customer/profile/all-query/delete-note/{note_id}',[CustomerProfileController::class,'deleteNote'])->name('delete-note');

    Route::get('user/{query_id}/update-query',[QueryController::class,'showUpdateQuery'])->name('user-showUpdateQuery');
    Route::post('user/{query_id}/update-query',[QueryController::class,'updateQuery'])->name('user-updateQuery');
    Route::get('user/{query_id}/delete',[QueryController::class,'deleteQuery'])->name('deleteQuery');

    Route::get('user/{query_id}/self-assign',[UserDashboardController::class,'querySelfAssign'])->name('query-self-assign');

    Route::post('user/{query_id}/self-assign',[ReqForTransferontroller::class,'storeReq'])->name('req-for-trans');
    Route::get('user/{query_id}/transfer-query/{req_id}/{id}',[ReqForTransferontroller::class,'approveReq'])->name('approve-req');
    Route::get('user/query-transfer-request/decline/{id}',[ReqForTransferontroller::class,'declineReq'])->name('decline-req');

    Route::get('user/view/single/query/{id}',[QueryController::class,'viewSingleQuery'])->name('view-single-query');


//   ======= invoice=====
    Route::get('user/all-invoice',[InvoiceController::class,'allInvoice'])->name('user-all-invoice');
    Route::get('user/all-invoice/search',[InvoiceController::class,'allInvoice'])->name('user-search-all-invoice');
    Route::get('user/all-invoice/date-filter',[InvoiceController::class,'allInvoice'])->name('user-all-invoice-date-filter');

    Route::get('user/generate-new-invoice',[InvoiceController::class,'viewInvoiceGenerator'])->name('view-new-invoice-generator');
    Route::post('user/generate-new-invoice',[InvoiceController::class,'newInvoice'])->name('new-generator');

    Route::post('user/customer/profile/{id}/quotation/{quotation_id}/make-invoice',[CustomerProfileController::class,'makeInvoice'])->name('user-make-invoice');

    Route::get('user/customer/profile/{id}/make-invoice',[CustomerProfileController::class,'viewGenerateNewInvoice'])->name('view-generate-new-invoice');
    Route::post('user/customer/profile/{id}/make-invoice',[CustomerProfileController::class,'generateNewInvoice'])->name('generate-new-invoice');


    Route::get('user/customer/profile/{id}/quotation/all-invoice',[CustomerProfileController::class,'allInvoice'])->name('all-invoice');
    Route::get('user/customer/profile/{id}/all-invoice/{invoice_id}/edit-Invoice',[CustomerProfileController::class,'viewEditInvoice'])->name('user-view-edit-invoice');
    Route::post('user/customer/profile/{id}/all-invoice/{invoice_id}/edit-Invoice',[CustomerProfileController::class,'updateInvoice'])->name('user-update-invoice');
    Route::get('user/customer/profile/{id}/all-invoice/{invoice_id}/edit-Invoice/{index_id}',[CustomerProfileController::class,'removeSingleProductInvoice'])->name('remove-single-product');
    Route::get('user/customer/profile/{id}/all-invoice/{invoice_id}/delete-Invoice',[CustomerProfileController::class,'deleteInvoice'])->name('user-delete-invoice');
    Route::get('user/customer/profile/{id}/all-invoice/{invoice_id}/view-invoice-pdf',[CustomerProfileController::class,'viewInvoicePdf'])->name('view-invoice-pdf');
    Route::get('user/customer/all-invoice/download-invoice/{invoice_id}',[CustomerProfileController::class,'downloadInvoicePdf'])->name('user-download-invoice');

    Route::get('user/all-invoice/{invoice_id}/challan',[InvoiceController::class,'challan'])->name('challan');

    Route::get('user/all-invoice/{invoice_id}/sent-mail',[InvoiceController::class,'invoiceMail'])->name('invoice-mail');
    Route::get('user/customer/profile/{id}/quotation/{quotation_id}/view-quotation',[CustomerProfileController::class,'viewQuotation'])->name('view-quotation-pdf');

    Route::get('user/all-invoice/{invoice_id}/money-receipt',[InvoiceController::class,'moneyReceipt'])->name('money-receipt');

    Route::get('update/all-invoice/status',[UpdateInvoiceStatusController::class,'updateInvoiceStatus'])->name('update-all-invoice-status');

    //    ==== Payment ====

    Route::get('user/all-payments',[PaymentController::class,'allPayment'])->name('all-payments');
    Route::get('user/customer/profile/{id}/all-payment',[CustomerProfileController::class,'allPayments'])->name('customer-all-payment');
    Route::get('user/customer/profile/{id}/quotation/{quotation_id}/make-payment',[CustomerProfileController::class,'viewAddPaymentForm'])->name('make-payment');
    Route::post('user/customer/profile/{id}/quotation/{quotation_id}/make-payment/{invoice_id}',[CustomerProfileController::class,'addPaymentFromInvoice'])->name('direct-add-payment');
    Route::get('user/customer/profile/{id}/add-payment/',[CustomerProfileController::class,'addPaymentsFromProfile'])->name('user-add-payment');
    Route::post('user/customer/profile/{id}/add-payment',[CustomerProfileController::class,'addPayment'])->name('add-payment');

    Route::get('user/add/payment/{invoice_id}/from-all-invoice/',[PaymentController::class,'showPayment'])->name('show-add-payment-from-all-invoice');
    Route::post('user/add/payment/{customer_id}/from-all-invoice/{invoice_id}',[PaymentController::class,'addPayment'])->name('add-payment-from-all-invoice');

    Route::get('user/customer/profile/{id}/quotation/make-payment',[CustomerProfileController::class,'addPaymentGenerateInvoice'])->name('make-payment-generate-invoice');

    Route::get('user/customer/profile/{id}/quotation/{quotation_id}/view-invoice-generator',[CustomerProfileController::class,'viewInvoiceGenerator'])->name('view-invoice-generator');

    Route::get('user/all-payments/{id}/money-rec',[PaymentController::class,'moneyRec'])->name('single-money_rec');



//    ========== Expenses ======

    Route::get('user/all-expanses/filter/',[ExpensesController::class,'viewAddExpanses'])->name('user-filter-expanse');
    Route::get('user/all-expanses/search/',[ExpensesController::class,'viewAddExpanses'])->name('user-search-expanse');

    Route::get('user/add-expanses',[ExpensesController::class,'viewAddExpanses'])->name('user-view-add-expanses');
    Route::post('user/add-expanses',[ExpensesController::class,'addExpanses'])->name('user-add-expanses');
    Route::get('user/expanse/update-expanse/{expanse_id}',[ExpensesController::class,'showEditExpanse'])->name('user-view-update-expanse');
    Route::post('user/expanse/update-expanse/{expanse_id}',[ExpensesController::class,'updateExpanse'])->name('user-update-expanse');
    Route::get('user/expanse/delete-expanse/{expanse_id}',[ExpensesController::class,'deleteExpanse'])->name('user-delete-expanse');
    Route::get('user/add-expanses/{invoice_id}',[ExpensesController::class,'viewAddExpanseWithInvoice'])->name('view-add-expanse-invoice');
    Route::post('user/add-expanses/{invoice_id}',[ExpensesController::class,'addExpanseWithInvoice'])->name('add-expanse-invoice');


//   ========== Old Database ==========
    Route::get('user/old-data/all-query/search',[OldDataController::class,'oldQuery'])->name('old-data-search-query');
    Route::get('user/old-data/all-query/date',[OldDataController::class,'oldQuery'])->name('old-query-date-filter');
    Route::get('user/old-data/all-query',[OldDataController::class,'oldQuery'])->name('old-all-query');


    Route::get('user/old-data/all-quotation',[OldDataController::class,'oldQuotation'])->name('old-all-quotation');
    Route::get('user/old-data/all-quotation/filter',[OldDataController::class,'oldQuotation'])->name('old-all-quotation-date-filter');
    Route::get('user/old-data/all-quotation/search',[OldDataController::class,'oldQuotation'])->name('old-all-quotation-search');


    Route::get('user/old-data/all-invoice',[OldDataController::class,'oldInvoice'])->name('old-all-invoice');
    Route::get('user/old-data/all-invoice/search',[OldDataController::class,'oldInvoice'])->name('old-all-invoice-search');
    Route::get('user/old-data/all-invoice/date',[OldDataController::class,'oldInvoice'])->name('old-all-invoice-date-filter');

//    ======quotation Mail=====
    Route::get('user/customer/profile/{id}/quotation/{quotation_id}/mail',[CustomerProfileController::class,'sentQuotationMail'])->name('sent-quotation-mail');


//    ==========Mail box ========

    Route::get('user/mail/accounts',[MailboxController::class,'emails'])->name('user-mail-list');
    Route::get('user/mail/accounts/{mail_id}/mail-folders',[MailboxController::class,'fetchMailFolders'])->name('user-fetch-mail-folders');
    Route::get('user/mail/accounts/{mail_id}/mail-folders/single-mail/{uid}/',[MailboxController::class,'viewSingleMail'])->name('single-mail');

    Route::get('user/mail/accounts/{mail_id}/mail-folders/mail-replay/{uid}/',[MailboxController::class,'mailRepaly'])->name('user-mail-replay');
    Route::post('user/mail/accounts/{mail_id}/mail-folders/mail-replay/{uid}/',[MailboxController::class,'sendReplay'])->name('send-replay');


//   ============== Calendar=================
    Route::get('user/calendar',[CalendarController::class,'calendar'])->name('user-calendar');
    Route::post('user/calendar',[CalendarController::class,'ajax'])->name('add-todo');

//    ==========Query Request Update ======

    Route::get('user/query-req-update/{req_id}/{query_id}',[UserDashboardController::class,'queryReqUpdate'])->name('update-query-request');
    Route::get('user/query-req-update/{req_id}/',[UserDashboardController::class,'queryReqDecline'])->name('decline-query-request');


//    ===== Task Update =======

    Route::get('user-task-update/{id}',[UserDashboardController::class,'checkAssign'])->name('task-done');

//    Notification Read ======

    Route::get('notification-read/{id}',[NotificationController::class,'markAsRead'])->name('noti-read');


//    ==========User Phone Number And Documents ============
    Route::get('user/phone-numbers',[PhoneNumbersController::class,'index'])->name('user-phone-numbers');
    Route::post('user/phone-numbers',[PhoneNumbersController::class,'addPhoneNumber'])->name('user-add-phonebook');

    Route::get('user/documents',[DocumentsController::class,'index'])->name('user-documents');
    Route::post('user/documents',[DocumentsController::class,'uploadFile'])->name('user-document-upload');

    Route::get('user/delete-document/{id}',[DocumentsController::class,'deleteDocument'])->name('user-delete-document');
    Route::get('user/document-download/{id}',[DocumentsController::class,'downloadDocument'])->name('user-download-document');


//  =============  Transactions ============

    Route::get('user/accounts',[AccountController::class,'index'])->name('user-accounts');
    Route::post('user/accounts/add-new',[AccountController::class,'addAccount'])->name('user-add-accounts');

    Route::post('user/cash-in/{account_id}',[TransactionController::class,'cashIn'])->name('user_cash_in');
    Route::post('user/cash-out/{account_id}',[TransactionController::class,'cashOut'])->name('user_cash_out');

    Route::get('user/all-transactions/{id}',[TransactionController::class,'showTransaction'])->name('user-view-transactions');

//    ========= Password Reset ===========

    Route::post('user/reset-password',[PasswordResetController::class,'passwordReset'])->name('user-reset-password');


//    Sent SMS ======

    Route::post('user/invoice/{invoice_id}/sent-sms',[SmsSentController::class,'sentSms'])->name('user-sent-sms');

    // User  Export Excel Route

    Route::get('user/export/queries/',[ReportExport::class,'exportQuery'])->name('user-query-export');


//    ====log out ========

    Route::get('user-logout',[UserLoginController::class,'logout'])->name('user-logout');

});



//===========Data transfer ============

//Route::get('insert/old-query-data',[MakeUserFromOldDatabase::class,'makeCustomersFromOldDatabase'])->name('insert-data');
//Route::get('insert/old-quotation',[MakeUserFromOldDatabase::class,'importQuotation'])->name('insert-quotation');
//
//Route::get('insert/old-queries',[MakeUserFromOldDatabase::class,'importQuery'])->name('insert-queries');
//Route::get('delete-all-query',[MakeUserFromOldDatabase::class,'deleteAllquery'])->name('delete-all-query');
//Route::get('delete-quotation',[MakeUserFromOldDatabase::class,'deleteQuotation'])->name('delete-all-quot');
//Route::get('update-old-quotation-vat',[MakeUserFromOldDatabase::class,'updateOldQuot'])->name('vat_update');
//Route::get('update/query-user-id',[MakeUserFromOldDatabase::class,'updateNullQuery'])->name('update-user-id');
//
//Route::get('update-quotations-queryId',[MakeUserFromOldDatabase::class,'updateQueryToQuotation'])->name('update-query-id');
//
//Route::get('import-invoices',[MakeUserFromOldDatabase::class,'importInvoice'])->name('import-invoice');
//
//Route::get('update-user-id-to-query',[MakeUserFromOldDatabase::class,'queryUserIdUpdate'])->name('update-user-id-to-query');
//
//Route::get('delete-invoice',[MakeUserFromOldDatabase::class,'deleteInvoice'])->name('delete-invoice');
//Route::get('update/query-created-at',[MakeUserFromOldDatabase::class,'updateCreated'])->name('update-created');
//Route::get('update/logo',[MakeUserFromOldDatabase::class,'updateQuotationLogo'])->name('update-quotation-logo');



//
Route::get('customer/profile/{id}/quotation/{quotation_id}/downloadPdf/',[CustomerProfileController::class,'downloadQuotationPdf'])->name('generate-pdf-download');
//

