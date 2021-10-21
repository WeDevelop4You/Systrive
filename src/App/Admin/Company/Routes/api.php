<?php

    use App\Admin\Company\Controllers\CompanyNavigationController;
    use App\Admin\Company\Controllers\CompanyShowController;
    use App\Admin\Company\Controllers\CompanyTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [CompanyNavigationController::class, 'index'])->name('user.company');

        Route::prefix('{company}')->middleware('company')->group(function () {
            Route::get('/', [CompanyShowController::class, 'index'])->name('user.company.show');
        });

        Route::prefix('admin')->group(function () {
            Route::get('table', [CompanyTableController::class, 'index'])->name('admin.companies');
        });
    });
