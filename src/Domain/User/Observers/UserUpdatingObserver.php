<?php

namespace Domain\User\Observers;

use Domain\User\Mappings\UserTableMap;
use Domain\User\Models\User;
use Domain\User\Notifications\UserPasswordChangeNotification;

class UserUpdatingObserver
{
    public function updating(User $user): void
    {
        if ($user->isDirty(UserTableMap::COL_EMAIL)) {
            $user->email_verified_at = null;

            // TODO Send verification email
        }

        if (
            ! \is_null($user->password) &&
            $user->isDirty(UserTableMap::COL_PASSWORD) &&
            ! \is_null($user->getOriginal(UserTableMap::COL_PASSWORD))
        ) {
            $user->notify(new UserPasswordChangeNotification());
        }
    }
}
