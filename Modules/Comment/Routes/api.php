<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\Api\v1\CommentController;

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

//Route::middleware('auth:api')->get('/comment', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:api')->prefix('v1')->group(function (){
    Route::post('/comment/{product}',[CommentController::class,'comment']);
});
