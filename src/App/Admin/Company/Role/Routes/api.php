<?php

    use App\Admin\Company\Role\Controllers\CompanyRoleListController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('list', [CompanyRoleListController::class, 'index'])->name('company.role.list');
    });
