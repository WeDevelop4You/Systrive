<?php

    use App\Admin\User\Controllers\UserController;
    use App\Admin\User\Controllers\UserDestroyController;
    use App\Admin\User\Controllers\UserDestroyForceController;
    use App\Admin\User\Controllers\UserListController;
    use App\Admin\User\Controllers\UserNavigationController;
    use App\Admin\User\Controllers\UserPermissionsController;
    use App\Admin\User\Controllers\UserTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth', [UserController::class, 'index'])->name('auth.user');
        Route::get('navigation', [UserNavigationController::class, 'index'])->name('auth.navigation');
        Route::get('auth/permissions', [UserPermissionsController::class, 'index'])->name('auth.user.permissions');

        Route::prefix('admin')->middleware('role:super_admin')->group(function () {
            Route::get('table', [UserTableController::class, 'index'])->name('admin.users');
            Route::get('list', [UserListController::class, 'index'])->name('admin.user.list');

            Route::prefix('{user}')->group(function () {
                Route::delete('/', [UserDestroyController::class, 'action'])->name('admin.user');
                Route::delete('force', [UserDestroyForceController::class, 'action'])->name('admin.user.force')->withTrashed();
            });
        });
    });
