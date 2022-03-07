<?php

    use App\Admin\Company\System\Domain\Controllers\CompanyDomainController;
    use App\Admin\Company\System\Domain\Controllers\CompanyDomainUsageController;

    Route::middleware('auth:sanctum')->prefix('{company}/system/{system}/domains')->group(function () {
        Route::get('{domain:name}', [CompanyDomainController::class, 'index'])->name('company.domain.search');

        Route::prefix('{domain}')->group(function () {
            Route::get('usage', [CompanyDomainUsageController::class, 'index'])->name('company.domain.usage');
        });
    });
