<?php

use Illuminate\Support\Facades\Route;
use Modules\Comment\Http\Controllers\admin\CommentController;

Route::get("comments/unapproved",[CommentController::class,"unapprovedComments"])->name("comments.unapproved");
Route::resource('comments', CommentController::class)->only(["index","destroy","update"]);
