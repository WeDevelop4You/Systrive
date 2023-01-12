<?php

namespace Domain\Authentication\Rules;

use Domain\User\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Contracts\Validation\Rule;

class RecoveryCodeRule implements Rule
{
    /**
     * RecoveryCodeRule constructor.
     *
     * @param User|null $user
     */
    public function __construct(
        private readonly ?User $user,
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

        if ($security?->enabled) {
            return $security->verifyRecoveryCode($value);
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
