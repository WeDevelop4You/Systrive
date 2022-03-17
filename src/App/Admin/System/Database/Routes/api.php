<?php

use App\Admin\System\Database\Controllers\CompanyDatabaseController;
use App\Admin\System\Database\Controllers\CompanyDatabaseUsageController;

Route::middleware('auth:sanctum')->prefix('{company}/system/{system}/databases')->group(function () {
    Route::get('{database:name}', [CompanyDatabaseController::class, 'index'])->name('company.database.search');

    Route::prefix('{database}')->group(function () {
        Route::get('usage', [CompanyDatabaseUsageController::class, 'index'])->name('company.database.usage');
    });
});
