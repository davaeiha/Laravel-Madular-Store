<?php

use Illuminate\Support\Facades\Route;
use Modules\Gallery\Http\Controllers\admin\ProductGalleryController;

Route::resource('product.gallery', ProductGalleryController::class);

