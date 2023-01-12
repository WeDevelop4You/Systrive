<?php

namespace Support\Providers;

use Domain\User\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rules\Password;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(10)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return route('account.view.reset.password', [
                $token,
                Crypt::encryptString($user->email),
            ]);
        });
    }
}
