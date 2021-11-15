<?php

    use App\Admin\Company\User\Controllers\CompanyUserEditController;
    use App\Admin\Company\User\Controllers\CompanyUserInviteController;
    use App\Admin\Company\User\Controllers\CompanyUserRevokeController;
    use App\Admin\Company\User\Controllers\CompanyUserTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [CompanyUserTableController::class, 'index'])->name('company.users');
        Route::post('/', [CompanyUserInviteController::class, 'action'])->name('company.user.invite');

        Route::prefix('{user}')->group(function () {
            Route::get('/', [CompanyUserEditController::class, 'index'])->name('company.user.edit');
            Route::patch('/', [CompanyUserEditController::class, 'action'])->name('company.user.edit');
            Route::delete('/', [CompanyUserRevokeController::class, 'action'])->name('company.user.revoke');
        });
    });
