<?php

use App\Misc\Navigation\Controllers\NavigationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('sub', [NavigationController::class, 'index'])->name('navigation.sub');
});
