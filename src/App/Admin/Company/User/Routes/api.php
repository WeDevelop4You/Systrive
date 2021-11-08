<?php

    use App\Admin\Company\User\Controllers\CompanyUserTableController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [CompanyUserTableController::class, 'index'])->name('company.users');
    });
