<?php

    use App\Admin\Company\System\Domain\Controllers\CompanyDomainUsageController;

    Route::middleware('auth:sanctum')->prefix('{company}/domains/{systemUserDomain}')->group(function () {
        Route::get('usage', [CompanyDomainUsageController::class, 'index'])->name('company.domain.usage');
    });
