<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LogInController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManageController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\UserRegistrationController;
use App\Http\Controllers\TicketCsvUploadController;
use App\Http\Controllers\StatisticsFileController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\MailSendController;
use App\Http\Controllers\MessageController;

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

Auth::routes();

Route::get('/user/login', [LoginController::class, 'showUserLoginForm'])->name('showUserLoginForm');
Route::post('/user/home', [LoginController::class,'userLogin'])->name('userLoginPost');
Route::get('/user/home', [LoginController::class,'userHome'])->name('userHome');

Route::get('/user/logout', [LogoutController::class,'userLogout'])->name('userLogout');

Route::group(['middleware' => 'auth:user'], function () {
    Route::view('/user', 'user');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::view('/admin', 'admin');
});

Route::get('/user/get/{id}', [UserRegistrationController::class, 'getInfo'])->name('userGet');
Route::get('/user/data_search', [LoginController::class, 'dataSearch'])->name('dataSearchGet');
Route::post('/user/update/{user_id}', [UserRegistrationController::class, 'updateInfo'])->name('userUpdatePost');
Route::get('/user/delete/{user_id}', [UserRegistrationController::class, 'delete'])->name('userDelete');
Route::post('user/report_file_export', [StatisticsFileController::class, 'reportFileExport'])->name('reportDownloadPost');

Route::post('/user/contact', [MailSendController::class, 'contactMail'])->name('contactPost');

Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('showAdminLoginForm');
Route::post('/admin/login', [LoginController::class,'adminLogin'])->name('adminLoginPost');
Route::get('/admin/logout', [LogoutController::class,'adminLogout'])->name('adminLogout');

Route::get('/admin/register', [AdminRegistrationController::class,'show'])->name('adminRegister');
Route::post('/admin/register', [AdminRegistrationController::class,'store'])->name('adminRegisterPost');

Route::get('/admin/home', [AdminDashboardController::class, 'index'])->name('adminHome');

Route::get('/admin/user_register', [UserRegistrationController::class, 'index'])->name('userRegister');
Route::post('/admin/user_register', [UserRegistrationController::class, 'store'])->name('userRegisterPost');

Route::post('/admin/home', [AdminDashboardController::class, 'store'])->name('newsRegisterPost');
Route::post('/admin/news_update/{no}', [AdminDashboardController::class, 'update'])->name('newsUpdatePost');
Route::get('/admin/news_delete/{no}', [AdminDashboardController::class, 'delete'])->name('newsDelete');

Route::get('/admin/manage', [AdminManageController::class, 'show'])->name('adminManage');
Route::get('/admin/get/{id}', [AdminManageController::class, 'getInfo'])->name('adminGet');
Route::post('/admin/update/{admin_id}', [AdminManageController::class, 'updateInfo'])->name('adminUpdatePost');
Route::get('/admin/delete/{admin_id}', [AdminManageController::class, 'delete'])->name('adminDelete');

Route::get('/admin/user_search', [UserRegistrationController::class, 'userSearch'])->name('userSearchPost');
Route::get('/admin/user_manage', [UserRegistrationController::class, 'show'])->name('userManage');

Route::get('/admin/visitor_csv_upload', [TicketCsvUploadController::class, 'createCsvForm'])->name('visitorCsvRegister');
Route::post('/admin/visitor_csv_upload', [TicketCsvUploadController::class, 'csvFileUpload'])->name('visitorCsvUpload');

Route::get('/admin/member_csv_upload', [ImportExportController::class, 'importUser'])->name('memberCsvFileRegister');
Route::post('/admin/member_csv_upload', [ImportExportController::class, 'import'])->name('memberCsvFileUpload');
Route::get('/admin/member_csv_export/{extension}', [ImportExportController::class, 'export'])->name('memberCsvFileExport');
Route::post('/admin/download_count_export', [ImportExportController::class, 'userCountExport'])->name('downloadCountExport');
Route::get('/admin/user_count_download', [ImportExportController::class, 'userCountShow'])->name('userCountDownload');

Route::get('/admin/visitor_csv_register', [TicketCsvUploadController::class,'createCsvForm'])->name('visitorCsvRegister');
Route::get('/admin/visitor_data', [TicketCsvUploadController::class,'show'])->name('visitorData');
Route::get('/admin/visitor_data_delete/{no}', [TicketCsvUploadController::class, 'delete'])->name('visitorDataDelete');

Route::get('/admin/statistics_file', [StatisticsFileController::class,'showStatisticsFile'])->name('statisticsFile');
Route::get('/admin/statistics_file_register', [StatisticsFileController::class,'showStatisticsFileRegister'])->name('statisticsFileRegister');
Route::post('/admin/statistics_file_register', [StatisticsFileController::class,'statisticsFileRegister'])->name('statisticsFileRegisterPost');
Route::get('/admin/statistics_file_update/{id}', [StatisticsFileController::class,'showStatisticsFileUpdate'])->name('statisticsFileUpdate');
Route::post('/admin/statistics_file_update/{id}', [StatisticsFileController::class,'statisticsFileUpdate'])->name('statisticsFileUpdatePost');
Route::get('/admin/statistics_file_delete/{id}', [StatisticsFileController::class, 'delete'])->name('statisticsFileDelete');
Route::get('admin/statistics_file_export/{id}', [StatisticsFileController::class, 'statisticsFileExport'])->name('statisticsFileExport');

Route::get('/admin/mail_status', [MailSendController::class, 'index'])->name('mail');
Route::get('/admin/mail_create', [MailSendController::class, 'show'])->name('mailCreate');
Route::post('/admin/mail_send', [MailSendController::class, 'sendMail'])->name('mailSendPost');
Route::get('/admin/mail_resend/{id}', [MailSendController::class, 'resendmail'])->name('mailResend');
Route::get('/admin/mail_update/{id}', [MailSendController::class, 'mailUpdate'])->name('mailUpdate');
Route::post('/admin/mail_update', [MailSendController::class, 'mailUpdatePost'])->name('mailUpdatePost');
Route::get('/admin/mail_search', [MailSendController::class, 'mailSearch'])->name('mailSearchGet');
Route::get('/admin/user_mail_search/{id}', [MailSendController::class, 'userMailSearch'])->name('userMailSearchGet');
Route::get('/admin/user_mail_update_search/{id}', [MailSendController::class, 'userMailUpdateSearch'])->name('userMailUpdateSearchGet');
Route::get('/admin/user_mail_create_search', [MailSendController::class, 'userMailCreateSearch'])->name('userMailCreateSearchGet');
