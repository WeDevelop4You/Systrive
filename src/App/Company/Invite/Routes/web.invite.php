<?php

use App\Company\Invite\Controllers\InviteStateController;

Route::get('{company}/{token}/{encryptEmail}', [InviteStateController::class, 'index'])->name('invite.link');
