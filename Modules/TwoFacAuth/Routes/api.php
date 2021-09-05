<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\TwoFacAuth\Http\Controllers\Api\v1\TwoFacAuthActivationController;
use Modules\TwoFacAuth\Http\Controllers\Api\v1\TwoFacAuthLoginController;

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

Route::middleware('auth:api')->prefix('/v1')->group(function (){
    //send 6-digits code to user via sms
    Route::post('/send-code',[TwoFacAuthActivationController::class,'sendCode']);

    //activate two-factor auth
    Route::post('/activate-2FA',[TwoFacAuthActivationController::class,'activateTwoFacAuth']);

    //deactivate two-factor auth
    Route::post('/deactivate-2FA',[TwoFacAuthActivationController::class,'deactivateTwoFacAuth']);

    //activate two-factor auth
    Route::post('/login-2FA',[TwoFacAuthLoginController::class,'loginViaTwoFac']);
});

