<?php

namespace Domain\User\Observers;

use Domain\User\Mappings\UserTableMap;
use Domain\User\Models\User;
use Domain\User\Notifications\UserPasswordChangeNotification;

class UserUpdatingObserver
{
    public function updating(User $user): void
    {
        if ($user->isDirty(UserTableMap::EMAIL)) {
            $user->email_verified_at = null;
        }

        if ($user->isDirty(UserTableMap::PASSWORD) && !\is_null($user->password)) {
            $user->notify(new UserPasswordChangeNotification());
        }
    }
}
