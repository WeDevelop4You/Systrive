<?php

    use App\Admin\Company\Controllers\CompanyCreateController;
    use App\Admin\Company\Controllers\CompanyDestroyController;
    use App\Admin\Company\Controllers\CompanyEditController;
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
            Route::post('/', [CompanyCreateController::class, 'action'])->name('admin.company.create');

            Route::prefix('{company}')->group(function () {
                Route::get('/', [CompanyEditController::class, 'index'])->name('admin.company.edit');
                Route::patch('/', [CompanyEditController::class, 'action'])->name('admin.company.edit');
                Route::delete('/', [CompanyDestroyController::class, 'action'])->name('admin.company.destroy');
            });
        });
    });
