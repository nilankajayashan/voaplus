<?php

use App\Http\Controllers\mail\SendEmailController;
use Illuminate\Support\Facades\Route;

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
Route::get('login', function () {
    return view('login');
})->name('login');

Route::get('forgot_password', function () {
    return view('user/forgot_password');
})->name('forgot_password');

Route::get('get_password_reset_code', function () {
    return view('user/password_reset_code');
})->name('get_password_reset_code');

Route::get('update_password', function () {
    return view('user/update_password');
})->name('update_password')->middleware('update_password_checker');

Route::get('change_password_profile', function () {
    return view('user/change_password_profile');
})->name('change_password_profile')->middleware('auth_user');

Route::get('register', function () {
    return view('register');
})->name('register');

Route::post('forgot_mail',[\App\Http\Controllers\LoginController::class, 'forgot_mail'])->name('forgot_mail');

Route::post('password_reset',[\App\Http\Controllers\LoginController::class, 'password_reset'])->name('password_reset');

Route::post('verify_password_reset_code',[\App\Http\Controllers\LoginController::class, 'verify_password_reset_code'])->name('verify_password_reset_code');

Route::post('change_password',[\App\Http\Controllers\LoginController::class, 'change_password'])->name('change_password');


Route::post('register_validate',[\App\Http\Controllers\RegistationController::class, 'register_validate'])->name('register_validate');

Route::post('login_validate',[\App\Http\Controllers\LoginController::class, 'login_validate'])->name('login_validate');

Route::get('logout',[\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('reset_login', function () {
    return view('reset_login');
})->middleware('auth_user')->name('reset_login')->middleware('is_verified');

Route::get('reset_login_state',[\App\Http\Controllers\LoginController::class, 'reset_login_state'])->name('reset_login_state')->middleware('auth_user')->middleware('is_verified');

Route::get('my_account',[\App\Http\Controllers\user\MyAccountController::class, 'index'])->name('my_account')->middleware('auth_user')->middleware('is_verified');
Route::get('channels',[\App\Http\Controllers\user\MyAccountController::class, 'showChannels'])->name('channels')->middleware('auth_user')->middleware('auth_stream')->middleware('is_verified');

Route::post('validate_token',[\App\Http\Controllers\user\MyAccountController::class, 'validate_token'])->name('validate_token')->middleware('auth_user')->middleware('is_verified');

Route::post('submit_change_password_profile',[\App\Http\Controllers\user\MyAccountController::class, 'change_password'])->name('submit_change_password_profile')->middleware('auth_user')->middleware('is_verified');

Route::get('view_stream',[\App\Http\Controllers\StreamController::class, 'view_stream'])->name('view_stream')->middleware('auth_user')->middleware('auth_stream')->middleware('is_verified');
Route::post('change-channel',[\App\Http\Controllers\StreamController::class, 'changeStream'])->name('change-channel')->middleware('auth_user')->middleware('auth_stream')->middleware('is_verified');

Route::get('check_stream',[\App\Http\Controllers\StreamController::class, 'check_stream'])->name('check_stream')->middleware('auth_user')->middleware('is_verified');

Route::post('package',[\App\Http\Controllers\PaymentController::class,'makePayment'])->name('package')->middleware('auth_user')->middleware('is_verified');

Route::post('free_package',[\App\Http\Controllers\user\MyAccountController::class,'free_package'])->name('free_package')->middleware('auth_user')->middleware('is_verified');

Route::get('payment_handle',[\App\Http\Controllers\PaymentController::class, 'payment_handle'])->name('payment_handle')->middleware('auth_user')->middleware('is_verified');

Route::get('verification', function () {
    return view('verification');
})->name('verification')->middleware('check_verification_view');

Route::post('account_verification',[\App\Http\Controllers\RegistationController::class, 'account_verification'])->name('account_verification');
Route::get('resent_verification',[\App\Http\Controllers\RegistationController::class, 'resent_verification'])->name('resent_verification');

Route::get('remove_device',[\App\Http\Controllers\LoginController::class, 'remove_device'])->name('remove_device');
Route::get('logged_stream',[\App\Http\Controllers\StreamController::class, 'logged_stream'])->name('logged_stream');

Route::get('/',[\App\Http\Controllers\IndexController::class, 'index'])->name('index');

//documentation
Route::get('how-to-watch', function (){
    return view('doc/how-to-watch');
})->name('how-to-watch');

Route::get('f-and-q', function (){
    return view('doc/f-and-q');
})->name('f-and-q');
