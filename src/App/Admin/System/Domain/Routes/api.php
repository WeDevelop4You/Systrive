<?php

use App\Admin\System\Domain\Controllers\SystemDomainEditController;
use App\Admin\System\Domain\Controllers\SystemDomainOverviewController;
use App\Admin\System\Domain\Controllers\SystemDomainUsageController;

Route::middleware('auth:sanctum')->prefix('{company}/{system}/domains')->scopeBindings()->group(function () {
    Route::get('{domain:name}/search', [SystemDomainOverviewController::class, 'index'])->name('system.domain.search');

    Route::prefix('{domain}')->group(function () {
        Route::get('{type}/usage', [SystemDomainUsageController::class, 'index'])->name('system.domain.usage');

        Route::prefix('edit')->controller(SystemDomainEditController::class)->group(function () {
            Route::get('/', 'index')->name('system.domain.edit');
            Route::patch('/', 'action')->name('system.domain.edit');
        });
    });
});