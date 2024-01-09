<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Middleware\TokenVerificationMiddleware;

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

// Route for User API
Route::get('/', function () { return view('welcome');});
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode'])->middleware(['auth:sanctum']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP'])->middleware(['auth:sanctum']);
Route::post('/reset-password',[UserController::class,'ResetPassword'])->middleware(['auth:sanctum']);
Route::get('/user-detail',[UserController::class,'GetUserDetails'])->middleware(['auth:sanctum']);
Route::post('/user-update',[UserController::class,'UpdateUserDetails'])->middleware(['auth:sanctum']);


// Route for User View
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/userLogin',[UserController::class,'LoginPage'])->name('login');
Route::get('/sendOTP',[UserController::class,'SendOTPPage']);
Route::get('/verifyOTP',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage']);
Route::get('/dashboard',[UserController::class,'DashboardPage']);
Route::get('/userProfile',[UserController::class,'UserProfilePage']);
Route::get('/logout',[UserController::class,'UserLogout'])->middleware(['auth:sanctum']);


//Category API and View
Route::post('/create-category',[CategoryController::class,'CreateCategory'])->middleware(['auth:sanctum']);
Route::post('/update-category',[CategoryController::class,'UpdateCategory'])->middleware(['auth:sanctum']);
Route::post('/delete-category',[CategoryController::class,'DeleteCategory'])->middleware(['auth:sanctum']);
Route::get('/list-category',[CategoryController::class,'ListCategory'])->middleware(['auth:sanctum']);
Route::post("/category-by-id",[CategoryController::class,'CategoryByID'])->middleware(['auth:sanctum']);
Route::get('/categoryPage',[CategoryController::class,'CategoryPage']);


// Customer API and View
Route::get('/customerPage',[CustomerController::class,'CustomerPage']);
Route::get('/list-customer',[CustomerController::class,'CustomerList'])->middleware(['auth:sanctum']);
Route::post('/customer-by-id',[CustomerController::class,'CustomerByID'])->middleware(['auth:sanctum']);
Route::post('/create-customer',[CustomerController::class,'CreateCustomer'])->middleware(['auth:sanctum']);
Route::post('/update-customer',[CustomerController::class,'UpdateCustomer'])->middleware(['auth:sanctum']);
Route::post('/delete-customer',[CustomerController::class,'DeleteCustomer'])->middleware(['auth:sanctum']);


// Product API and View
// Route::get('/productPage',[UserController::class,'ProductPage']);
// Route::get('/productList',[UserController::class,'ProductList'])->middleware(['auth:sanctum']);
// Route::get('/productByID',[UserController::class,'ProductByID'])->middleware(['auth:sanctum']);
// Route::post('/create-product',[UserController::class,'CreateProduct'])->middleware(['auth:sanctum']);







