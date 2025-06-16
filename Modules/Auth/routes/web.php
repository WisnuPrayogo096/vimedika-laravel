<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('auth.login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::get('/branch', [AuthController::class, 'showSelectBranchForm'])->name('auth.select-branch.view');
    Route::post('/branch', [AuthController::class, 'selectBranch'])->name('auth.select-branch');

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('auth.login.view');
});
