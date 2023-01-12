<?php

namespace Domain\Authentication\Rules;

use Domain\User\Models\User;
use Domain\User\Models\UserSecurity;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Rule;

class OneTimePasswordRule implements Rule
{
    /**
     * RecoveryCodeRule constructor.
     *
     * @param User|null $user
     * @param bool      $verifying
     */
    public function __construct(
        private readonly ?User $user,
        private readonly bool $verifying = false
    ) {
        //
    }

    /**
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $security = $this->user?->security;

        if ($security instanceof UserSecurity && ($security->enabled || $this->verifying)) {
            return $security->verifyOneTimePassword($value);
        }

        return false;
    }

    /**
     * @return Application|array|string|Translator|null
     */
    public function message(): array|string|Translator|Application|null
    {
        return trans('validation.invalid.code');
    }
}
