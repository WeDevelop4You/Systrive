<?php


use App\Admin\Company\System\DNS\Controllers\CompanyDNSController;
use App\Admin\Company\System\DNS\Controllers\CompanyDNSRecordTableController;

Route::middleware('auth:sanctum')->prefix('{company}/system/{system}/dns')->group(function () {
    Route::get('{dns:name}', [CompanyDNSController::class, 'index'])->name('company.dns.search');

    Route::prefix('{dns}')->group(function () {
        Route::prefix('table')->group(function () {
            Route::get('items', [CompanyDNSRecordTableController::class, 'items'])->name('company.dns.record.table.items');
            Route::get('headers', [CompanyDNSRecordTableController::class, 'headers'])->name('company.dns.record.table.headers');
        });
    });
});
