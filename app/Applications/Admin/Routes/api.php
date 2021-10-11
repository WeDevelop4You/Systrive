<?php

    use App\Admin\Company\Controllers\CompaniesController;
    use App\Admin\User\Controllers\UserController;
    use App\Admin\User\Controllers\UserTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'auth'])->name('auth.user');

        Route::prefix('companies')->group(function () {
            Route::get('/', [CompaniesController::class, 'navigation'])->name('user.company');

            Route::prefix('{company}')->middleware('company')->group(function () {
                Route::get('/', [CompaniesController::class, 'show'])->name('user.company.show');
            });
        });

        Route::prefix('admin')->group(function () {
            Route::get('users', [UserTableController::class, 'index'])->name('admin.users');
        });


    });

