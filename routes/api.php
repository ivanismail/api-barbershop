<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

 //*AUTH
 Route::prefix("auth")->group(function(){
    Route::post("login", [AuthController::class, "login"]);
    Route::post("register", [AuthController::class, "register"]);
});
//*MUSH LOGIN
Route::middleware('auth:sanctum')->group(function () {    
    Route::get('shaver', [ApiController::class, 'shaver']);
    Route::get('service-category', [ApiController::class, 'service_category']);
    Route::post('service', [ApiController::class, 'service']);
    Route::get('booking', [ApiController::class, 'booking']);
    // //*USER
    // Route::prefix('profile')->name('profile.')->group(function () {
    //     Route::get('/', [UserController::class, 'profile'])->name('profile');
    //     Route::post('/update-photo', [UserController::class, 'updateFotoProfile'])->name('updateFotoProfile');
    //     Route::post('/update', [UserController::class, 'updateProfile'])->name('updateProfile');
    //     Route::post('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    //     Route::post('/check', [UserController::class, 'check'])->name('check');
    //     Route::post('/delete-account', [UserController::class, 'deleteAccount'])->name('deleteAccount');
    // });
    // //*GENERAL SETTING
    // Route::prefix('general-setting')->name('general-setting.')->group(function () {
    //     Route::post('/', [GeneralSettingController::class, 'fetch'])->name('fetch');
    //     Route::post('/icon', [GeneralSettingController::class, 'icon'])->name('icon');
    // });
});
