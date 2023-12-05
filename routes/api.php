<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
   
// Email verification routes
Route::post('/email/verification-notification', [UserController::class, 'sendVerificationEmail'])
->middleware(['throttle:6,1'])
->name('verification.send');

Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])
->middleware(['signed'])
->name('verification.verify');

Route::get('/email/verify', [UserController::class,'emailVerified'])->name('verification.notice');

// public routes
Route::post('register',[UserController::class,'registerUser']);
Route::post('login',[UserController::class,'loginUser']); 
                        
// ptotected routes
Route::group(['middleware' => 'auth:sanctum'],function(){  //['auth:sanctum','verified']
    Route::get('users',[UserController::class,'allUsers']);
    Route::get('logged-user',[UserController::class,'userDetails']);
    Route::get('user/{id}',[UserController::class,'user']);
    Route::post('image-upload',[UserController::class,'imageUpload']); 
    Route::delete('delete/{id}',[UserController::class,'deleteUser']);
    Route::get('logout',[UserController::class,'logout']);
    Route::get('refresh-token',[UserController::class,'refreshAuthToken']);
});