<?php

use Illuminate\Support\Facades\Route;
use Modules\Management\Http\Controllers\Admin\ManagementController;

Route::prefix('management')->group(function (){
    Route::get('/',[ManagementController::class,'index'])->name('management');
    Route::patch('/enable/{moduleName}',[ManagementController::class,'enable'])->name('management.enable');
    Route::patch('/disable/{moduleName}',[ManagementController::class,'disable'])->name('management.disable');
});

