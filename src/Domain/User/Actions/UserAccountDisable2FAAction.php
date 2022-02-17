<?php

    namespace Domain\User\Actions;

    use Domain\User\Models\User;

    class UserAccountDisable2FAAction
    {
        public function __invoke(User $user)
        {
            $user->security()->delete();
        }
    }
