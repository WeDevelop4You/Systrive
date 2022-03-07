<?php


use App\Admin\Company\System\DNS\Controllers\CompanyDNSController;

Route::middleware('auth:sanctum')->prefix('{company}/system/{system}/dns')->group(function () {
    Route::get('{dns:name}', [CompanyDNSController::class, 'index'])->name('company.dns.search');
});
