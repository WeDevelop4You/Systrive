<?php

use App\Admin\Git\Controllers\GitDisconnectController;
use App\Admin\Git\Controllers\GitRepositoryBranchController;
use App\Admin\Git\Controllers\GitRepositoryController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('{service}')->group(function () {
        Route::delete('disconnect', [GitDisconnectController::class, 'action'])->name('git.services.disconnect');

        Route::prefix('repositories')->group(function () {
            Route::get('/', [GitRepositoryController::class, 'index'])->name('git.repositories');
            Route::get('/branches', [GitRepositoryBranchController::class, 'index'])->name('git.repository.branches');
        });
    });
});
