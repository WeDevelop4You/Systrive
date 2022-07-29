<?php

use App\Admin\Job\Controller\JobOverviewController;
use App\Admin\Job\Controller\JobProcessTableController;
use App\Admin\Job\Controller\JobScheduleTableController;
use App\Admin\Job\Controller\JobShowController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('overview', [JobOverviewController::class, 'index'])->name('admin.job.schedule.overview');

    Route::prefix('schedules')->group(function () {
        Route::dataTable(JobScheduleTableController::class, 'admin.job.schedule', 'schedules');

        Route::prefix('{schedule}')->group(function () {
            Route::prefix('processes')->group(function () {
                Route::dataTable(JobProcessTableController::class, 'admin.job.schedule.process');
                Route::get('show', [JobShowController::class, 'index'])->name('admin.job.schedule.process.show');
            });
        });
    });

    Route::prefix('processes')->group(function () {
        Route::dataTable(JobProcessTableController::class, 'admin.job.process');
        Route::get('show', [JobShowController::class, 'index'])->name('admin.job.process.show');
    });
});
