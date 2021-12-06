<?php

    namespace Domain\User\Actions;

    use Domain\User\Models\User;
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Str;

    class EditPasswordAction
    {
        public function __construct(
            public User $user,
        ) {
            //
        }

        public function __invoke(string $password)
        {
            $this->user->forceFill([
                'password' => Hash::make($password),
            ])->setRememberToken(Str::random(60));

            $this->user->save();

            event(new PasswordReset($this->user));
        }
    }
