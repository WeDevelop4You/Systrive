<?php

use App\Admin\Startup\Controllers\MainNavigationController;
use App\Admin\Startup\Controllers\SubNavigationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('navigation')->group(function () {
        Route::get('/', [MainNavigationController::class, 'index'])->name('navigation.main');
        Route::get('sub', [SubNavigationController::class, 'index'])->name('navigation.sub');
    });
});
