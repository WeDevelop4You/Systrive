<?php

use App\Company\Invite\Controllers\InviteUserAcceptedController;

Route::prefix('{token}')->controller(InviteUserAcceptedController::class)->group(function () {
    Route::get('/', 'index')->name('invite.user.accepted');
    Route::post('/', 'action')->name('invite.user.accepted');
});
