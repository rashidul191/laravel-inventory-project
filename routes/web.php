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
    return view('welcome');
});

Route::post('/user-registration', [UserController::class, 'userRegistration'])->name('user-registration.registration');
Route::post('/user-login', [UserController::class, 'userLogin'])->name('user-login.login');
Route::post('/send-otp', [UserController::class, 'sendOTPCode'])->name('send-otp.otp');
Route::post('/verify-otp', [UserController::class, 'verifyOTP'])->name('verify-otp.otp');

// Token Verify
Route::post('/reset-password', [UserController::class, 'resetUserPassword'])->name('reset-user-password.reset-password')->middleware([TokenVerificationMiddleware::class]);
