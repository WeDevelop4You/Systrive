<?php


use App\Admin\System\DNS\Controllers\CompanyDNSController;
use App\Admin\System\DNS\Controllers\CompanyDNSRecordTableController;

Route::middleware('auth:sanctum')->prefix('{company}/system/{system}/dns')->group(function () {
    Route::get('{dns:name}', [CompanyDNSController::class, 'index'])->name('company.dns.search');

    Route::prefix('{dns}')->group(function () {
        Route::dataTable(CompanyDNSRecordTableController::class, 'company.dns.record');
    });
});
