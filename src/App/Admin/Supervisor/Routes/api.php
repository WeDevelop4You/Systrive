<?php

use App\Admin\Supervisor\Controllers\SupervisorOverviewController;
use App\Admin\Supervisor\Controllers\SupervisorProcessCreateController;
use App\Admin\Supervisor\Controllers\SupervisorProcessDestroyController;
use App\Admin\Supervisor\Controllers\SupervisorProcessEditController;
use App\Admin\Supervisor\Controllers\SupervisorRestartController;
use App\Admin\Supervisor\Controllers\SupervisorShowController;
use App\Admin\Supervisor\Controllers\SupervisorStartController;
use App\Admin\Supervisor\Controllers\SupervisorStopController;
use App\Admin\Supervisor\Controllers\SupervisorTableController;

Route::dataTable(SupervisorTableController::class, 'supervisor');
Route::get('show', [SupervisorShowController::class, 'index'])->name('supervisor.show');
Route::get('overview', [SupervisorOverviewController::class, 'index'])->name('supervisor.overview');

Route::prefix('process')->group(function () {
    Route::post('start/{name?}', [SupervisorStartController::class, 'action'])->name('supervisor.process.start');
    Route::post('stop/{name?}', [SupervisorStopController::class, 'action'])->name('supervisor.process.stop');
    Route::post('restart/{name}', [SupervisorRestartController::class, 'action'])->name('supervisor.process.restart');

    Route::prefix('create')->controller(SupervisorProcessCreateController::class)->group(function () {
        Route::get('/', 'index')->name('supervisor.process.create');
        Route::post('/', 'action')->name('supervisor.process.create');
    });

    Route::prefix('{supervisor}')->group(function () {
        Route::prefix('edit')->controller(SupervisorProcessEditController::class)->group(function () {
            Route::get('/', 'index')->name('supervisor.process.edit');
            Route::patch('/', 'action')->name('supervisor.process.edit');
        });

        Route::prefix('delete')->controller(SupervisorProcessDestroyController::class)->group(function () {
            Route::get('/', 'index')->name('supervisor.process.destroy');
            Route::delete('/', 'action')->name('supervisor.process.destroy');
        });
    });
});
