<?php

use App\Admin\Supervisor\Controllers\SupervisorOverviewController;
use App\Admin\Supervisor\Controllers\SupervisorProcessEditController;
use App\Admin\Supervisor\Controllers\SupervisorRestartController;
use App\Admin\Supervisor\Controllers\SupervisorStartController;
use App\Admin\Supervisor\Controllers\SupervisorStopController;

Route::middleware('auth:sanctum')->middleware('role:super_admin')->group(function () {
    Route::get('overview', [SupervisorOverviewController::class, 'index'])->name('admin.supervisor.overview');
    Route::post('start/{name?}', [SupervisorStartController::class, 'action'])->name('admin.supervisor.start');
    Route::post('stop/{name?}', [SupervisorStopController::class, 'action'])->name('admin.supervisor.stop');
    Route::post('restart/{name}', [SupervisorRestartController::class, 'action'])->name('admin.supervisor.restart');

    Route::prefix('edit')->controller(SupervisorProcessEditController::class)->group(function () {
        Route::get('/', 'index')->name('admin.supervisor.process.edit');
        Route::patch('/', 'action')->name('admin.supervisor.process.edit');
    });
});
