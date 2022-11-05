<?php

use App\Admin\System\Database\Controllers\SystemDatabaseOverviewController;
use App\Admin\System\Database\Controllers\SystemDatabaseUsageController;

Route::prefix('{company}/{system}/databases')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:system.view')
    ->scopeBindings()
    ->group(function () {
        Route::get('{database:name}/search', [SystemDatabaseOverviewController::class, 'index'])->name('system.database.search');

        Route::prefix('{database}')->group(function () {
            Route::get('usage', [SystemDatabaseUsageController::class, 'index'])->name('system.database.usage');
        });
    });
