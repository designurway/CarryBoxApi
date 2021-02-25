<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;


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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("customer/register",[CustomerController::class,"register"]);

Route::post("customer/generateMobileOtp",[CustomerController::class,"generateMobileOtp"]);

Route::post("customer/generateEmailOtp",[CustomerController::class,"generateEmailOtp"]);

Route::post("customer/login",[CustomerController::class,"login"]);

Route::get("customer/getContact",[CustomerController::class,"getContact"]);

Route::post("customer/updatePassword",[CustomerController::class,"updatePassword"]);
