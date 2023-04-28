<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\DeviceTokenController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\ForgetPasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('products',ProductController::class);

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');


Route::post('device-tokens', [DeviceTokenController::class, 'store'])
    ->middleware('auth:sanctum');

Route::post('email_verification',[EmailVerificationController::class,'email_verification']);

Route::post('password/forget-password' ,[ForgetPasswordController::class, 'forgetPassword']);
Route::post('password/reset' ,[ForgetPasswordController::class, 'resetPassword']);
