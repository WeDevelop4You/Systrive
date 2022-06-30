<?php

    use App\Admin\Permission\Controllers\PermissionController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions');
    });
