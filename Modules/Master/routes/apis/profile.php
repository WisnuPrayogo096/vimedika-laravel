<?php

use Illuminate\Support\Facades\Route;
use Modules\Master\Http\Controllers\ProfileController;

Route::prefix('/api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'findAllDataProfile'])->name('api.profile');
});