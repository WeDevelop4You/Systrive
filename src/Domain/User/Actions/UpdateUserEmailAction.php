<?php

namespace Domain\User\Actions;

use Domain\User\Models\User;

class UpdateUserEmailAction
{
    public function __construct(
        private readonly User $user
    ) {
        //
    }

    public function __invoke(string $email): void
    {
        $user = $this->user;
        $user->email = $email;
        $user->save();
    }
}
