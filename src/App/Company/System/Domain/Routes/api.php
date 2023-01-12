<?php

use App\Company\System\Domain\Controllers\SystemDomainEditController;
use App\Company\System\Domain\Controllers\SystemDomainOverviewController;
use App\Company\System\Domain\Controllers\SystemDomainUsageController;

Route::prefix('{system}/domains')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:system.view')
    ->scopeBindings()
    ->group(function () {
        Route::get('{domain:name}/search', [SystemDomainOverviewController::class, 'index'])->name('system.domain.search');

        Route::prefix('{domain}')->group(function () {
            Route::get('{type}/usage', [SystemDomainUsageController::class, 'index'])->name('system.domain.usage');

            Route::prefix('edit')->controller(SystemDomainEditController::class)->group(function () {
                Route::get('/', 'index')->name('system.domain.edit');
                Route::patch('/', 'action')->name('system.domain.edit');
            });
        });
    });
