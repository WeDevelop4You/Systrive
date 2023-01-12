<?php

use App\Admin\Dashboard\Controllers\DashboardController;

Route::get('{any?}', [DashboardController::class, 'index'])->where('any', '^(?!api)[\/\w\.-]*')->name('view.dashboard');
