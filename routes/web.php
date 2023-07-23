<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\BotManController;
use App\Http\Controllers\SystemAdministratorController;
use Illuminate\Support\Facades\Route;


$app_url = config("app.url");
if (!empty($app_url)) {
    URL::forceRootUrl($app_url);
    $schema = explode(':', $app_url)[0];
    URL::forceScheme($schema);
}


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('/welcome','welcome');

//ROUTE FOR BOTMAN
Route::match(['get', 'post'], 'botman', [BotManController::class, 'handle']);

Route::get('/errors/js',[SystemAdministratorController::class, 'javascriptError']);

Auth::routes(['verify'=>true]);

Route::group(['middleware' => ['AccountStatusMiddleware', 'auth', 'EmailVerify']], function() {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | FINAL ROUTES BELOW
    |--------------------------------------------------------------------------
    |
    | 
    |
    */

    //CLINIC EMPLOYE APPLY
    Route::prefix('apply')->group(function() {
        Route::get('/', [EmployeeController::class, 'index'])->middleware(CheckEmployee::class);
        Route::post('/', [EmployeeController::class, 'store']);
    });

    //CLINIC CREATE
    Route::resource('clinic/clinic', ClinicController::class)->only([
        'create', 'store'
    ]);

    //CLINIC RESUBSCRIBE
    Route::get('/resubscribe', [ClinicController::class, 'resubscribe']);
    Route::post('/resubscribe/store', [ClinicController::class, 'store_resubscribe']);

    Route::group(['middleware' => ['ClinicStatus', 'ClinicSubscriptionStatus','EmployeeStatus']], function () { 

        //CLINIC VIEW/EDIT
        Route::prefix('clinic/clinic')->group(function(){
            Route::get('/single', [ClinicController::class, 'single']);
            Route::get('/edit', [ClinicController::class, 'edit'])->middleware(ClinicAdmin::class);
            Route::put('/{clinic}/info', [ClinicController::class, 'update_info'])->middleware(ClinicAdmin::class);    
            Route::put('/{clinic}/picture', [ClinicController::class, 'update_picture'])->middleware(ClinicAdmin::class);
            Route::put('/{clinic}/payment', [ClinicController::class, 'update_payment'])->middleware(ClinicAdmin::class);
            Route::put('/{clinic}/license', [ClinicController::class, 'update_license'])->middleware(ClinicAdmin::class);
            Route::post('/{clinic}/subscription', [ClinicController::class, 'update_subscription'])->middleware(ClinicAdmin::class);
        });
     
        //CLINIC DASHBOARD
        Route::get('/clinic/dashboard/index', [ClinicController::class, 'dashboard_clinic'])->middleware(ClinicAdmin::class);

        //CLINIC SERVICE
        Route::get('/clinic/service/create', [ServiceController::class, 'create'])->middleware(ClinicAdmin::class);
        Route::post('/clinic/service', [ServiceController::class, 'store'])->middleware(ClinicAdmin::class);
        Route::get('/clinic/service/index', [ServiceController::class, 'index']);
        Route::get('/clinic/service/list', [ServiceController::class, 'getService']);
        Route::get('/clinic/service/{id}/edit', [ServiceController::class, 'edit'])->middleware([ClinicService::class, ClinicAdmin::class]);
        Route::put('/clinic/service/{service}', [ServiceController::class, 'update']);
        Route::delete('/clinic/service/{id}', [ServiceController::class, 'destroy']);

        //CLINIC BOOKING
        Route::get('/clinic/booking/index', [BookingController::class, 'display_booking_clinic']);
        Route::get('/clinic/booking/list', [BookingController::class, 'getBooking']);
        Route::get('/clinic/booking/{id}/view', [BookingController::class, 'assign_booking'])->middleware([ClinicBooking::class, ClinicAdmin::class]);
        Route::get('/clinic/booking/employeelist', [BookingController::class, 'assignBooking']);
        Route::put('/clinic/booking/{booking}/view/{employee}', [BookingController::class, 'update_first_booking']);
        Route::get('/clinic/booking/{id}/editlink', [BookingController::class, 'edit_link'])->middleware(ClinicBooking::class, ClinicAdmin::class);
        Route::put('/clinic/booking/{booking}', [BookingController::class, 'update_link']);
        Route::get('/clinic/booking/{id}/display', [BookingController::class, 'booking_details'])->middleware(ClinicBooking::class);
        Route::get('/clinic/booking/{id}/cancel', [BookingController::class, 'cancel_request'])->middleware(ClinicBooking::class, ClinicAdmin::class);
        Route::delete('/clinic/booking/{booking}', [BookingController::class, 'cancel_booking']);

        //CLINIC RECORD
        Route::get('/clinic/record/index', [ClinicController::class, 'display_records']);
        Route::get('/clinic/record/list', [ClinicController::class, 'getRecord']);
        Route::get('/clinic/record/{id}/view', [ClinicController::class, 'view_records'])->middleware(ClinicRecord1::class);
        Route::get('/clinic/record/{patient}/history', [ClinicController::class, 'history_records'])->middleware(ClinicRecord2::class);

        //CLINIC EMPLOYEE
        Route::get('/clinic/employee/index', [ClinicController::class, 'display_employee'])->middleware(ClinicAdmin::class);
        Route::get('/clinic/employee/list', [ClinicController::class, 'getEmployee'])->middleware(ClinicAdmin::class);
        Route::put('/clinic/employee/{id}/accept', [ClinicController::class, 'accept_employee'])->middleware(ClinicAdmin::class);
        Route::delete('/clinic/employee/{id}/decline', [ClinicController::class, 'decline_employee'])->middleware(ClinicAdmin::class);
        Route::put('/clinic/employee/{id}/update', [ClinicController::class, 'update_employee'])->middleware(ClinicAdmin::class);

        //CLINIC CALENDAR
        Route::get('/clinic/calendar', [ClinicController::class, 'calendar']);

        //CLINIC NOTIFICATION
        Route::get('/clinic/notification/index', [ClinicController::class, 'notification'])->middleware(ClinicAdmin::class);
        Route::get('/clinic/notification/list', [ClinicController::class, 'getNotification'])->middleware(ClinicAdmin::class);
        Route::delete('/clinic/notification/{id}', [ClinicController::class, 'delete_notification'])->middleware(ClinicAdmin::class);
        
    });

    Route::group(['middleware' => 'ClinicEmployee'], function () { 

        //EMPLOYEE/ADMIN ASSIGNED BOOKING
        Route::get('/booking/employee/index', [BookingController::class, 'display_booking_employee']);
        Route::get('/booking/employee/list', [BookingController::class, 'getBookingEmployee']);
        Route::get('/booking/employee/{id}/editlink', [BookingController::class, 'edit_link_employee'])->middleware(EmployeeBooking1::class);
        Route::put('/booking/employee/{booking}', [BookingController::class, 'update_link_employee']);
        Route::get('/booking/employee/{id}/display', [BookingController::class, 'booking_employee_details'])->middleware(EmployeeBooking1::class);
        Route::get('/record/{booking}/show', [BookingController::class, 'display_patient_records'])->middleware(EmployeeBooking2::class);
        Route::put('/record/{booking}', [BookingController::class, 'update_patient_records']);
        Route::get('/record/{booking}/history', [BookingController::class, 'display_patient_history'])->middleware(EmployeeBooking2::class);
        Route::get('/booking/employee/{id}/remarks', [BookingController::class, 'create_booking_remarks'])->middleware(EmployeeBooking1::class);
        Route::put('/booking/employee/{booking}/store', [BookingController::class, 'store_booking_remarks']);

        //EMPLOYEE/ADMIN CALENDAR
        Route::get('/calendar/index', [ClinicController::class, 'calendar_employee']);

    });

    Route::group(['middleware' => 'PatientMiddleware'], function () { 

        //BOOKING SEARCH
        Route::post('/booking/search', [BookingController::class, 'search']);

        //BOOKING ROUTES
        Route::prefix('booking')->group(function() {

            //MANUAL BOOKING
            Route::get('/', [BookingController::class, 'index']);
            Route::get('/{clinic}/show', [BookingController::class, 'show']);
            Route::get('/{clinic}/view', [BookingController::class, 'view']);
            Route::get('/{clinic}/{service}/display', [BookingController::class, 'display']); 
            Route::post('/{clinic}/{service}/display', [BookingController::class, 'store_booking']);

        });

        //QUICK BOOKING
        Route::get('/booking/quick', [BookingController::class, 'quick_booking']);
        Route::get('/booking/{service}/displayquick', [BookingController::class, 'quick_booking_display']);
        Route::post('/booking/{service}/quick-display-store', [BookingController::class, 'store_quick_booking']); 

        //PATIENT BOOKING
        Route::get('/booking/patient/index', [BookingController::class, 'display_booking_patient']);
        Route::get('/booking/patient/list', [BookingController::class, 'getBookingPatient']);
        Route::get('/booking/patient/{id}/view', [BookingController::class, 'view_booking_details'])->middleware(PatientBooking::class);
        Route::get('/booking/patient/{id}/ratings', [BookingController::class, 'create_booking_ratings'])->middleware(PatientBooking::class);
        Route::post('/booking/patient/{booking}', [BookingController::class, 'store_booking_ratings']);
        Route::get('/booking/patient/{id}/cancel', [BookingController::class, 'booking_patient_cancel'])->middleware(PatientBooking::class);
        Route::put('/booking/patient/{booking}/cancel', [BookingController::class, 'cancel_booking_patient']);

        //PATIENT CALENDAR
        Route::get('/profile/calendar/index', [ProfileController::class, 'calendar']);

        //PATIENT MEDICAL RECORD
        Route::get('/profile/record/index', [ProfileController::class, 'record']);
        Route::get('/profile/record/list', [ProfileController::class, 'getRecord']);
        Route::get('/profile/record/{id}/view', [ProfileController::class, 'view_record'])->middleware(PatientRecord1::class);
        Route::get('/profile/record/{record}/history', [ProfileController::class, 'view_history'])->middleware(PatientRecord2::class);

        //ROUTE FOR JOURNAL FOR PATIENTS
        Route::get('/profile/journal/index', [ProfileController::class, 'journal']);
        Route::get('/profile/journal/list', [ProfileController::class, 'getJournal']);
        Route::get('/profile/journal/create', [ProfileController::class, 'create_journal']);
        Route::get('/profile/journal/{id}/view', [ProfileController::class, 'view_journal'])->middleware(PatientJournal::class);
        Route::get('/profile/journal/{id}/edit', [ProfileController::class, 'edit_journal'])->middleware(PatientJournal::class);
        Route::post('/profile/journal/store', [ProfileController::class, 'store_journal']);
        Route::put('/profile/journal/{journal}/update', [ProfileController::class, 'update_journal']);
        Route::delete('/profile/journal/{id}', [ProfileController::class, 'delete_journal']);

    });

    //VIEW PROFILE FOR ALL USERS
    Route::get('/profile/profile/index', [ProfileController::class, 'index']);

    //EDIT PROFILE FOR ALL USERS
    Route::get('/profile/profile/edit', [ProfileController::class, 'edit']);
    Route::get('/profile/profile/change', [ProfileController::class, 'change_password']);
    Route::put('/profile/profile/changepassword', [ProfileController::class, 'update_password']);
    Route::put('/profile/profile/updateinfo', [ProfileController::class, 'update_info']);
    Route::put('/profile/profile/updateimage', [ProfileController::class, 'update_image']);

    //VIEW NOTIFICATION FOR ALL USERS
    Route::get('/profile/notification/index', [ProfileController::class, 'notification']);
    Route::get('/profile/notification/list', [ProfileController::class, 'getNotification']);

    //VIEW TICKET FOR ALL USERS
    Route::get('/profile/ticket/index', [ProfileController::class, 'ticket']);
    Route::get('/profile/ticket/list', [ProfileController::class, 'getTicket']);
    Route::get('/profile/ticket/create', [ProfileController::class, 'create_ticket']);
    Route::post('/profile/ticket', [ProfileController::class, 'store_ticket']);
    Route::get('/profile/ticket/{id}/view', [ProfileController::class, 'view_ticket'])->middleware(OwnTicket::class);
    Route::put('/profile/ticket/{var}', [ProfileController::class, 'store_comment']);

    //SEARCH/REPORT COMMUNITY FORUM
    Route::post('/forum/search', [ForumController::class, 'search']);
    Route::post('/forum/category', [ForumController::class, 'searchCategory']);
    Route::get('/forum/{forum}/warningForum', [ForumController::class, 'create_forum_warning'])->middleware(Report1::class);
    Route::post('/forum/{forum}/warningForum/store', [ForumController::class, 'forum_warning']);
    Route::get('/forum/{comment}/warningForumComment', [ForumController::class, 'create_forumComment_warning'])->middleware(Report2::class);
    Route::post('/forum/{comment}/warningForumComment/store', [ForumController::class, 'forumComment_warning']);

    //FORUM POSTS
    Route::resource('forum', ForumController::class)->except([
        'show', 'edit'
    ]);

    //FORUM COMMENTS
    Route::prefix('forum')->group(function(){
        Route::get('{forum}/edit', [ForumController::class, 'edit'])->middleware(OwnPost::class);
        Route::get('{forum}/show', [ForumController::class, 'show']);
        Route::post('/{forum}', [ForumController::class, 'store_comment']);
    });

    Route::group(['middleware' => 'SystemAdministratorMiddleware'], function () { 

        //PDF
        Route::get('/systemadmin/log/pdf', [SystemAdministratorController::class, 'generatePDF']);

        //ROUTES FOR VIEW/MANAGE TICKET FOR SYSAD
        Route::get('/systemadmin/ticket/index', [SystemAdministratorController::class, 'ticket']);
        Route::get('/systemadmin/ticket/list', [SystemAdministratorController::class, 'getTicket']); 
        Route::get('/systemadmin/ticket/create', [SystemAdministratorController::class, 'create_ticket']);
        Route::post('/systemadmin/ticket', [SystemAdministratorController::class, 'store_ticket']);
        Route::get('/systemadmin/ticket/{id}/view', [SystemAdministratorController::class, 'view_ticket']);
        Route::put('/systemadmin/ticket/{var}', [SystemAdministratorController::class, 'store_comment']);
        Route::put('/systemadmin/ticket/{id}/update', [SystemAdministratorController::class, 'close_ticket']);
        Route::put('/systemadmin/ticket/{id}/archive', [SystemAdministratorController::class, 'archive_ticket']);

        //ROUTES FOR MANAGE CLINIC FOR SYSAD
        Route::get('/systemadmin/clinic/index', [SystemAdministratorController::class, 'clinic']);
        Route::get('/systemadmin/clinic/list', [SystemAdministratorController::class, 'getClinic']); 
        Route::put('/systemadmin/clinic/{id}', [SystemAdministratorController::class, 'activate_clinic']);

        //ROUTES FOR MANAGE PAYMENT FOR SYSAD
        Route::get('/systemadmin/payment/index', [SystemAdministratorController::class, 'payment']);
        Route::get('/systemadmin/payment/list', [SystemAdministratorController::class, 'getPayment']); 
        Route::put('/systemadmin/payment/{id}/accept', [SystemAdministratorController::class, 'accept_payment']);
        Route::put('/systemadmin/payment/{id}/decline', [SystemAdministratorController::class, 'decline_payment']);
        Route::delete('/systemadmin/payment/{id}', [SystemAdministratorController::class, 'delete_payment']);

        //ROUTES FOR MANAGE USERS FOR SYSAD
        Route::get('/systemadmin/user/index', [SystemAdministratorController::class, 'user']);
        Route::get('/systemadmin/user/list', [SystemAdministratorController::class, 'getUser']); 
        Route::get('/systemadmin/user/{id}/notification', [SystemAdministratorController::class, 'send_notification']);
        Route::post('/systemadmin/user/{var}/storenotification', [SystemAdministratorController::class, 'store_notification']);
        Route::get('/systemadmin/user/{id}/warning', [SystemAdministratorController::class, 'send_warning']);
        Route::put('/systemadmin/user/{var}/storewarning', [SystemAdministratorController::class, 'store_warning']);
        Route::get('/systemadmin/user/{id}/award', [SystemAdministratorController::class, 'send_award_user']);
        Route::post('/systemadmin/user/{var}/storeaward', [SystemAdministratorController::class, 'store_award_user']);    
        Route::put('/systemadmin/user/{id}', [SystemAdministratorController::class, 'activate_user']);

        //ROUTES FOR MANAGE FORUM POSTS
        Route::get('/systemadmin/forum/index', [SystemAdministratorController::class, 'forum']);
        Route::get('/systemadmin/forum/list', [SystemAdministratorController::class, 'getForum']);
        Route::delete('/systemadmin/forum/{id}', [SystemAdministratorController::class, 'delete_forum']);
        
        //ROUTES FOR MANAGE FORUM COMMENTS 
        Route::get('/systemadmin/forum/{id}/comment/index', [SystemAdministratorController::class, 'forumComment']);
        Route::get('/systemadmin/commentForum/{forum}/list', [SystemAdministratorController::class, 'getForumComment']);
        Route::delete('/systemadmin/commentForum/{id}' , [SystemAdministratorController::class, 'delete_comment']);

        //ROUTES FOR MANAGE AUDIT LOGS
        Route::get('/systemadmin/log/index', [SystemAdministratorController::class, 'log']);
        Route::get('/systemadmin/log/list', [SystemAdministratorController::class, 'getLog']); 

        //ROUTE FOR SYSTEM ADMIN DASHBOARD
        Route::get('/systemadmin/dashboard/index', [SystemAdministratorController::class, 'dashboard_admin']);

        //ROUTE FOR MANAGE WARNING FOR SYSAD
        Route::get('/systemadmin/warning/index', [SystemAdministratorController::class, 'warning']);
        Route::get('/systemadmin/warning/list', [SystemAdministratorController::class, 'getWarning']);        

        
    });

});






