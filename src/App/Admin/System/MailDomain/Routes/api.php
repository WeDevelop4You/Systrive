<?php

use App\Admin\System\MailDomain\Controllers\SystemMailDomainAddressTableController;
use App\Admin\System\MailDomain\Controllers\SystemMailDomainController;
use App\Admin\System\MailDomain\Controllers\SystemMailDomainUsageController;

Route::prefix('{company}/{system}/mail/domains')
    ->middleware('auth:sanctum')
    ->middleware('permission.company:system.view')
    ->scopeBindings()
    ->group(function () {
        Route::get('{mailDomain:name}/search', [SystemMailDomainController::class, 'index'])->name('system.mail.domain.search');

        Route::prefix('{mailDomain}')->group(function () {
            Route::dataTable(SystemMailDomainAddressTableController::class, 'system.mail.domain.address');
            Route::get('usage', [SystemMailDomainUsageController::class, 'index'])->name('system.mail.domain.usage');
        });
    });
