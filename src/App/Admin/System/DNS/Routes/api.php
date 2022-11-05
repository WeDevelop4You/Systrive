<?php


use App\Admin\System\DNS\Controllers\SystemDNSOverviewController;
use App\Admin\System\DNS\Controllers\SystemDNSRecordTableController;

Route::prefix('{company}/{system}/dns')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:system.view')
    ->scopeBindings()
    ->group(function () {
        Route::get('{dns:name}/search', [SystemDNSOverviewController::class, 'index'])->name('system.dns.search');

        Route::prefix('{dns}')->group(function () {
            Route::dataTable(SystemDNSRecordTableController::class, 'system.dns.record');
        });
});
