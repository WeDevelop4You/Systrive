<?php

use App\Misc\Session\Controllers\DeleteSessionController;
use Illuminate\Support\Facades\Route;

Route::delete('delete', [DeleteSessionController::class, 'action'])->name('session.delete');
