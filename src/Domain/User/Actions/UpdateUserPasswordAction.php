<?php

    namespace Domain\User\Actions;

    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class UpdateUserPasswordAction
    {
        public function __construct(
            public User $user,
        ) {
            //
        }

        public function __invoke(string $password): void
        {
            $this->user->forceFill([
                UserTableMap::COL_PASSWORD => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $this->user->save();
        }
    }
