<?php

    namespace Domain\User\Actions;

    use Domain\User\Models\User;

    class UserAccountDeleteSecurityAction
    {
        public function __invoke(User $user)
        {
            $user->security()->delete();
        }
    }
