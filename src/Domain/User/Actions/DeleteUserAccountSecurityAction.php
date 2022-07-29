<?php

    namespace Domain\User\Actions;

    use Domain\User\Models\User;

    class DeleteUserAccountSecurityAction
    {
        public function __invoke(User $user): void
        {
            $user->security()->delete();
        }
    }
