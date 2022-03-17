<?php

    use App\Admin\Company\Controllers\CompanyCreateController;
    use App\Admin\Company\Controllers\CompanyDestroyController;
    use App\Admin\Company\Controllers\CompanyEditController;
    use App\Admin\Company\Controllers\CompanyInviteController;
    use App\Admin\Company\Controllers\CompanyNavigationController;
    use App\Admin\Company\Controllers\CompanyResendInviteController;
    use App\Admin\Company\Controllers\CompanyShowController;
    use App\Admin\Company\Controllers\CompanyTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('search/{company:name}', [CompanyShowController::class, 'index'])->name('company.search');

        Route::prefix('{company}')->group(function () {
            Route::get('/', [CompanyShowController::class, 'index'])->name('company.show');
            Route::get('navigation', [CompanyNavigationController::class, 'index'])->name('company.navigation');

            Route::prefix('complete/{token}')->group(function () {
                Route::get('/', [CompanyCreateController::class, 'index'])->name('company.complete');
                Route::patch('/', [CompanyCreateController::class, 'action'])->name('company.complete');
            });
        });

        Route::prefix('admin')->middleware('role:super_admin')->group(function () {
            Route::dataTable(CompanyTableController::class, 'admin.company');
            Route::post('/', [CompanyInviteController::class, 'action'])->name('admin.company.create');

            Route::prefix('{company}')->group(function () {
                Route::get('/', [CompanyEditController::class, 'index'])->name('admin.company.edit');
                Route::patch('/', [CompanyEditController::class, 'action'])->name('admin.company.edit');
                Route::delete('/', [CompanyDestroyController::class, 'action'])->name('admin.company.destroy');

                Route::post('invite/resend', [CompanyResendInviteController::class, 'action'])->name('admin.company.invite.resend');
            });
        });
    });
