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

// Route for API
Route::get('/', function () { return view('welcome');});
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware(['auth:sanctum']);
//Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware([TokenVerificationMiddleware::class]); 



// Route for View
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/userLogin',[UserController::class,'LoginPage'])->name('login');
Route::get('/sendOTP',[UserController::class,'SendOTPPage']);
Route::get('/verifyOTP',[UserController::class,'VerifyOTPPage']);
Route::get('/userResetPassword',[UserController::class,'ResetPasswordPage']);
Route::get('/dashboard',[UserController::class,'DashboardPage']);
Route::get('/user-profile',[UserController::class,'UserProfilePage'])->middleware(['auth:sanctum']);
//User logout Route
Route::get('/logout',[UserController::class,'UserLogout'])->middleware(['auth:sanctum']);
// User details Update Route
Route::post('/update-user',[UserController::class,'UpdateUserDetails'])->middleware(['auth:sanctum']);

//Route::get('/dashboard',[UserController::class,'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);



