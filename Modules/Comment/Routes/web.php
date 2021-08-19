<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * send comment using ajax
 */
Route::post('/comments',function (Request $request){
    if(!$request->ajax()){
        return response()->json([
            "status"=>"just ajax request"
        ]);
    }

    $validatedData  = $request->validate([
        "comment"=>"required",
        "commentable_id"=>"required",
        "commentable_type"=>"required",
        "parent_id"=>"required"
    ]);

    $request->user()->comments()->create($validatedData);
    alert()->success("نظر شما با موفقیت ثبت شد");
    return back();

})->name('send.comment');
