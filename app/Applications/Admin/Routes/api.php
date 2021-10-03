<?php

    use App\Admin\Auth\Controllers\AuthenticationController;
    use App\Admin\User\Controllers\UserController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('auth/user', [UserController::class, 'index'])->name('auth.user');
//        Route::get('roles', [RolesController::class, 'index'])->name('role.all');
    });
