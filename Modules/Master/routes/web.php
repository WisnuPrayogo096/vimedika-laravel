<?php

use Illuminate\Support\Facades\Route;
use Modules\Master\Http\Controllers\MasterController;

foreach (glob(base_path('Modules/Master/routes/apis/*.php')) as $routeFile) {
    require $routeFile;
}

Route::middleware(['auth', 'verified'])->group(function () { 
    Route::resource('masters', MasterController::class)->names('master');
});