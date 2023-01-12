<?php

use App\Admin\Navigation\Controllers\NavigationController;

Route::get('/', [NavigationController::class, 'index'])->name('navigation');
