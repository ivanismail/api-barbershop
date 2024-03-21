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
    Route::get('booking', [ApiController::class, 'history']);
    Route::get('booking', [ApiController::class, 'booking']);
    Route::get('profile', [ApiController::class, 'profile']);
    Route::post('general-setting', [ApiController::class, 'gs']);
});
