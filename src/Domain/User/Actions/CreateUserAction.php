<?php

namespace Domain\User\Actions;

use Carbon\Carbon;
use Domain\User\Models\User;

class CreateUserAction
{
    /**
     * @param string $email
     *
     * @return User
     */
    public function __invoke(string $email): User
    {
        $user = User::withTrashed()->whereEmail($email)->firstOrNew();

        if (!$user->exists) {
            $user->email = $email;
            $user->deleted_at = Carbon::now();
            $user->save();
        }

        return $user;
    }
}
