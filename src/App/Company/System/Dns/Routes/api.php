<?php

use App\Company\System\Dns\Controllers\SystemDNSOverviewController;
use App\Company\System\Dns\Controllers\SystemDNSRecordTableController;

Route::prefix('{system}/dns')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:system.view')
    ->scopeBindings()
    ->group(function () {
        Route::get('{dns:name}/search', [SystemDNSOverviewController::class, 'index'])->name('system.dns.search');

        Route::prefix('{dns}')->group(function () {
            Route::dataTable(SystemDNSRecordTableController::class, 'system.dns.record');
        });
    });
