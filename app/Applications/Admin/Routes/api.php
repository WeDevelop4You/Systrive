<?php

    use App\Admin\Company\Controllers\CompaniesController;
    use App\Admin\User\Controllers\UserController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'index'])->name('auth.user');

        Route::prefix('companies')->group(function () {
            Route::get('/', [CompaniesController::class, 'index'])->name('user.company');

            Route::prefix('{company}')->middleware('company')->group(function () {
                Route::get('/', function() {
                    dd('test');
                });
            });
        });
    });
