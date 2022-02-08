<?php

    namespace Domain\User\Actions;

    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class UpdatePasswordAction
    {
        public function __construct(
            public User $user,
        ) {
            //
        }

        public function __invoke(string $password)
        {
            $this->user->forceFill([
                UserTableMap::PASSWORD => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $this->user->save();

            event(new PasswordReset($this->user));
        }
    }
