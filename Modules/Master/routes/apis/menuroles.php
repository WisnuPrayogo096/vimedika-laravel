<?php

use Illuminate\Support\Facades\Route;
use Modules\Master\Http\Controllers\MenuRolesController;

Route::prefix('/api')->group(function () {
    Route::get('/menus', [MenuRolesController::class, 'findAllMenus'])->name('api.menus');
});