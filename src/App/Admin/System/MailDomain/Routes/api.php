<?php

use App\Admin\System\MailDomain\Controllers\CompanyMailDomainAddressTableController;
use App\Admin\System\MailDomain\Controllers\CompanyMailDomainController;
use App\Admin\System\MailDomain\Controllers\CompanyMailDomainUsageController;

Route::middleware('auth:sanctum')->prefix('{company}/system/{system}/mail/domains')->group(function () {
    Route::get('{mailDomain:name}', [CompanyMailDomainController::class, 'index'])->name('company.mail.domain.search');

    Route::prefix('{mailDomain}')->group(function () {
        Route::dataTable(CompanyMailDomainAddressTableController::class, 'company.mail.domain.address');
        Route::get('usage', [CompanyMailDomainUsageController::class, 'index'])->name('company.mail.domain.usage');
    });
});
