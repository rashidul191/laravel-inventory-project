<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
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
    return redirect()->route('userLogin.loginPage');
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
// Route::get('/userLogin', [UserController::class, 'loginPage'])->name('userLogin.loginPage');
// Route::get('/userRegistration', [UserController::class, 'registrationPage'])->name('userRegistration.registrationPage');
// Route::get('/sendOTP', [UserController::class, 'sendOTPPage'])->name('sendOTP.sendOTPPage');
// Route::get('/verifyOTP', [UserController::class, 'verifyOTPPage'])->name('verifyOTP.verifyOTPPage');


Route::controller(UserController::class)->group(function () {
    Route::get('/userLogin', 'loginPage')->name('userLogin.loginPage');
    Route::get('/userRegistration', 'registrationPage')->name('userRegistration.registrationPage');
    Route::get('/sendOTP', 'sendOTPPage')->name('sendOTP.sendOTPPage');
    Route::get('/verifyOTP', 'verifyOTPPage')->name('verifyOTP.verifyOTPPage');
});

// Route::get('/resetPassword', [UserController::class, 'resetPasswordPage'])->name('resetPassword.resetPasswordPage')->middleware([TokenVerificationMiddleware::class]);;
// Route::get('/dashboard', [UserController::class, 'dashboardPage'])->name('dashboard.dashboardPage')->middleware([TokenVerificationMiddleware::class]);

Route::middleware([TokenVerificationMiddleware::class])->group(function () {
    Route::get('/resetPassword', [UserController::class, 'resetPasswordPage'])->name('resetPassword.resetPasswordPage');
    Route::get('/dashboard', [UserController::class, 'dashboardPage'])->name('dashboard.dashboardPage');
    Route::get('/userProfile', [UserController::class, 'userProfilePage'])->name('userProfile.userProfilePage');

    Route::get('/user-profile', [UserController::class, 'userProfileGet'])->name('user-profile.userProfile');
    Route::post('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile.updateProfile');

    // Category Route
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categoryPage', 'categoryPage')->name('category.categoryPage');
        Route::get('/list-category', 'getCategory')->name('listCategory.getCategory');
        Route::post('/create-category', 'createCategory')->name('create-category.category');
        Route::post('/delete-category', 'categoryDelete')->name('delete-category.category');
        Route::get('/category-by-id/{id}', 'categoryById')->name('category-by-id.category');
        Route::post('/update-category', 'categoryUpdate')->name('update-category.category');
    });


    // Customer Route
    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customerPage', 'customerPage')->name('customer-page');
        Route::get('/customerList', 'customerList');
        Route::post('/customerCreate', 'customerCreate');
        Route::delete('/customerDelete/{id}', 'customerDelete');
        Route::get('/customer-by-id/{id}', 'customerById');
        Route::put('/customerUpdate/{id}', 'customerUpdate');
    });

    // Product Route
    Route::controller(ProductController::class)->group(function () {
        Route::get('/productPage', 'productPage')->name('productPage');
        Route::get('/productList', 'productList')->name('productList');
        Route::post('/productCreate', 'productCreate')->name('productCreate');
        Route::post('/productDelete', 'productDelete')->name('productDelete');
        Route::get('/productGetById/{id}', 'productGetById')->name('productGetById');
        Route::post('/productUpdate/{id}', 'productUpdate')->name('productUpdate');
    });

    // Invoice Route
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoicePage', 'invoicePage')->name('invoicePage');
    });
});
