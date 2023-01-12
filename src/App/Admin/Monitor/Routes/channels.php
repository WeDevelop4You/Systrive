<?php

use Domain\User\Models\User;

Broadcast::channel('admin.monitor.table.channel', function(User $user) {
    setCompanyId();

    return $user->isSuperAdmin();
});
