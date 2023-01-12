<?php

use App\Company\Git\Controllers\GitAuthenticationController;

Route::prefix('{service}')->middleware('auth:sanctum')->group(function () {
    Route::get('login', [GitAuthenticationController::class, 'index'])->name('git.login');
    Route::get('callback', [GitAuthenticationController::class, 'action'])->name('git.callback');
});
