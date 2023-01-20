<?php

namespace App\Account\Authentication\Requests;

use Domain\Authentication\Exceptions\RequiresSecurityException;
use Domain\Authentication\Rules\OneTimePasswordRule;
use Domain\Authentication\Rules\RecoveryCodeRule;
use Domain\User\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rule = match ($this->route()->getName()) {
            'account.login.rc' => $this->recoveryCodeRule(),
            'account.login.otp' => $this->oneTimePasswordRule(),
            default => []
        };

        return [...$this->defaultRules(), ...$rule];
    }

    /**
     * @return array[]
     */
    private function defaultRules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @return array[]
     */
    private function oneTimePasswordRule(): array
    {
        return [
            'one_time_password' => [
                'required',
                'digits:6',
                new OneTimePasswordRule(
                    User::whereEmail($this->get('email'))->with('security')->first(),
                ),
            ],
        ];
    }

    /**
     * @return array[]
     */
    private function recoveryCodeRule(): array
    {
        return [
            'recovery_code' => [
                'required',
                'string',
                'regex:/^([\d\w]{10})-([\d\w]{10})/',
                new RecoveryCodeRule(
                    User::whereEmail($this->get('email'))->with('security')->first()
                ),
            ],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws ValidationException
     * @throws RequiresSecurityException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $this->ensureSecurity();

        if (! Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'password' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws ValidationException
     */
    private function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'password' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * @return void
     *
     * @throws RequiresSecurityException
     */
    private function ensureSecurity(): void
    {
        if (Config::get('app.security') && $this->routeIs('account.login')) {
            $user = User::whereEmail($this->get('email'))->with('security')->first();

            if ($user?->security?->enabled) {
                throw new RequiresSecurityException();
            }
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    private function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
