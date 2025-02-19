<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return "Laravel Inventory Home Page";
});

// Web API Routes
Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user-registration.registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user-login.login');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name('send-otp.otp');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verify-otp.otp');
// Token Verify
Route::post('/reset-password', [UserController::class, 'resetUserPassword'])->name('reset-user-password.reset-password')->middleware([TokenVerificationMiddleware::class]);
Route::get('/logout', [UserController::class, 'userLogout'])->name('logout.user-logout');


// Page Routes
Route::get('/userLogin', [UserController::class, 'loginPage'])->name('userLogin.loginPage');
Route::get('/userRegistration', [UserController::class, 'registrationPage'])->name('userRegistration.registrationPage');
Route::get('/sendOTP', [UserController::class, 'sendOTPPage'])->name('sendOTP.sendOTPPage');
Route::get('/verifyOTP', [UserController::class, 'verifyOTPPage'])->name('verifyOTP.verifyOTPPage');


// Route::get('/resetPassword', [UserController::class, 'resetPasswordPage'])->name('resetPassword.resetPasswordPage')->middleware([TokenVerificationMiddleware::class]);;
// Route::get('/dashboard', [UserController::class, 'dashboardPage'])->name('dashboard.dashboardPage')->middleware([TokenVerificationMiddleware::class]);

Route::middleware([TokenVerificationMiddleware::class])->group(function () {
    Route::get('/resetPassword', [UserController::class, 'resetPasswordPage'])->name('resetPassword.resetPasswordPage');
    Route::get('/dashboard', [UserController::class, 'dashboardPage'])->name('dashboard.dashboardPage');
});
