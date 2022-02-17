<?php

    namespace Support\Rules;

    use Domain\User\Models\User;
    use Domain\User\Models\UserSecurity;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\Translation\Translator;
    use Illuminate\Contracts\Validation\DataAwareRule;
    use Illuminate\Contracts\Validation\Rule;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Crypt;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
    use PragmaRX\Google2FA\Google2FA;

    class OneTimePasswordRule implements Rule, DataAwareRule
    {
        private array $data;

        public function __construct(
            public bool $creating = false
        ) {

        }

        public function setData($data)
        {
            $this->data = $data;
        }

        /**
         * @param string $attribute
         * @param mixed  $value
         *
         * @return bool
         */
        public function passes($attribute, $value): bool
        {
            if (Auth::check()) {
                $user = Auth::user();
            } else {
                $user = User::whereEmail($this->data['email'])->first();
            }

            $security = $user->security;

            if ($security instanceof UserSecurity && ($security->enabled || $this->creating)) {
                try {
                    $google2fa = new Google2FA();

                    return $google2fa->verifyKey(Crypt::decryptString($security->secret_key), (string) $value);
                } catch (IncompatibleWithGoogleAuthenticatorException|
                    InvalidCharactersException|
                    SecretKeyTooShortException|
                    DecryptException
                ) {
                    return false;
                }
            }

            return true;
        }

        /**
         * @return Application|array|string|Translator|null
         */
        public function message(): array|string|Translator|Application|null
        {
            return trans('validation.invalid.one_time_password');
        }
    }
