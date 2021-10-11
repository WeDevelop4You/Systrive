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
            Route::prefix('users')->group(function ()  {
                Route::get('/', [UserTableController::class, 'index'])->name('admin.users');

                Route::prefix('{user}')->group(function () {
                    Route::delete('delete', [UserTableController::class, 'destroy'])->name('admin.user.destroy');
                    Route::delete('delete/force', [UserTableController::class, 'forceDestroy'])->name('admin.user.destroy.force');
                });
            });
        });


    });

