<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard.superadmin');
})
    ->name('dashboard')
    ->middleware('check.token');
