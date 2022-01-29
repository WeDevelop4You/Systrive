<?php

    use App\Admin\Company\Role\Controllers\CompanyRoleCreateController;
    use App\Admin\Company\Role\Controllers\CompanyRoleDestroyController;
    use App\Admin\Company\Role\Controllers\CompanyRoleEditController;
    use App\Admin\Company\Role\Controllers\CompanyRoleListController;
    use App\Admin\Company\Role\Controllers\CompanyRoleTableController;

    Route::prefix('{company}/roles')->middleware('auth:sanctum')->group(function () {
        Route::get('/', [CompanyRoleTableController::class, 'index'])->name('company.roles');
        Route::get('list', [CompanyRoleListController::class, 'index'])->name('company.role.list');
        Route::post('create', [CompanyRoleCreateController::class, 'action'])->name('company.role.create');

        Route::prefix('{role}')->scopeBindings()->group(function () {
            Route::get('/', [CompanyRoleEditController::class, 'index'])->name('company.role.edit');
            Route::patch('/', [CompanyRoleEditController::class, 'action'])->name('company.role.edit');
            Route::delete('/', [CompanyRoleDestroyController::class, 'action'])->name('company.role.destroy');
        });
    });
