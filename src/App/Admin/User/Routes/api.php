<?php

    use App\Admin\User\Controllers\UserController;
    use App\Admin\User\Controllers\UserDestroyController;
    use App\Admin\User\Controllers\UserDestroyForceController;
    use App\Admin\User\Controllers\UserTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'index'])->name('auth.user');

        Route::prefix('admin')->group(function () {
            Route::get('table', [UserTableController::class, 'index'])->name('admin.users');

            Route::prefix('{user}')->group(function () {
                Route::delete('/', [UserDestroyController::class, 'action'])->name('admin.user');
                Route::delete('force', [UserDestroyForceController::class, 'action'])->name('admin.user.force')->withTrashed();
            });
        });
    });
