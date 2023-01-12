<?php

use App\Admin\Monitor\Controllers\MonitorOverviewController;
use App\Admin\Monitor\Controllers\MonitorTableController;

Route::dataTable(MonitorTableController::class, 'monitor');
Route::get('overview', [MonitorOverviewController::class, 'index'])->name('monitor.overview');
