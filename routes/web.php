<?php

use App\Http\Controllers\UserController;
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
Route::post('/user-registration',[UserController::class,'UserRegistration']);
Route::post('/user-login',[UserController::class,'UserLogin']);

// Route::get('/user-logout',[UserController::class,'UserLogout']);
// Route::get('/user-profile',[UserController::class,'UserProfile']);
// Route::post('/user-update',[UserController::class,'UserUpdate']);
// Route::post('/user-delete',[UserController::class,'UserDelete']);
// Route::get('/user-list',[UserController::class,'UserList']);
// Route::get('/user-details/{id}