<?php

use App\Admin\Invite\Controllers\InviteStateController;

Route::get('{company}/{token}/{encryptEmail}', [InviteStateController::class, 'index'])->name('invite.link');
