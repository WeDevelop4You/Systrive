<?php

namespace App\Admin\Authentication\Requests;

use Domain\Authentication\Exceptions\RequiredOneTimePasswordException;
use Domain\Authentication\Rules\SecurityRule;
use Domain\User\Models\User;
use Domain\User\Models\UserSecurity;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'one_time_password' => ['bail', 'sometimes', 'digits:6', new SecurityRule()],
            'recovery_code' => ['bail', 'sometimes', 'string', 'regex:/^([\d\w]{10})-([\d\w]{10})/', new SecurityRule()],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     * @throws RequiredOneTimePasswordException
     *
     * @return void
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();
        $this->requiresOneTimePassword();

        if (!Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
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
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
     * @throws RequiredOneTimePasswordException
     */
    public function requiresOneTimePassword(): void
    {
        if (config('app.security') && !$this->hasAny(['one_time_password', 'recovery_code'])) {
            $user = User::whereEmail($this->get('email'))->first();

            if ($user instanceof User && $user->security instanceof UserSecurity && $user->security->enabled) {
                throw new RequiredOneTimePasswordException();
            }
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey(): string
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
