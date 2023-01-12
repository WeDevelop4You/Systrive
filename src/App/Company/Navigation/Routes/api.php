<?php

use App\Company\Navigation\Controllers\NavigationController;

Route::get('/', [NavigationController::class, 'index'])->name('navigation');
