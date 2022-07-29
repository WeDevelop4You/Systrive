<?php

    namespace Support\Helpers;

    use Domain\User\Models\UserSecurity;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
    use PragmaRX\Google2FA\Google2FA;

    class SecurityHelper
    {
        /**
         * @var Google2FA
         */
        private Google2FA $provider;

        /**
         * RecoveryCodeHelper constructor.
         *
         * @param ?UserSecurity $security
         */
        private function __construct(
            private ?UserSecurity $security
        ) {
            $this->provider = new Google2FA();
        }

        /**
         * @param ?UserSecurity $security
         *
         * @return SecurityHelper
         */
        public static function create(?UserSecurity $security): SecurityHelper
        {
            return new static($security);
        }

        /**
         * @param bool $creating
         *
         * @return bool
         */
        public function enabled(bool $creating = false): bool
        {
            return ($this->security instanceof UserSecurity && ($this->security->enabled || $creating));
        }

        /**
         * @throws DecryptException
         *
         * @return string
         */
        public function getKey(): string
        {
            return Crypt::decryptString($this->security->secret_key);
        }

        /**
         * @throws DecryptException
         *
         * @return array
         */
        public function getRecoveryCodes(): array
        {
            return Crypt::decrypt($this->security->recovery_codes);
        }

        /**
         * @return SecurityHelper
         */
        public function setRecoveryCodes(): SecurityHelper
        {
            $recoveryCodes = Collection::times(8, function () {
                return $this->generateRecoveryCode();
            })->toArray();

            $this->saveRecoveryCodes($recoveryCodes);

            return $this;
        }

        /**
         * @param string $oneTimePassword
         *
         * @return bool
         */
        public function verify(string $oneTimePassword): bool
        {
            try {
                return (bool) $this->provider->verifyKey($this->getKey(), $oneTimePassword);
            } catch (IncompatibleWithGoogleAuthenticatorException|InvalidCharactersException|SecretKeyTooShortException|DecryptException) {
                return false;
            }
        }

        /**
         * @param string $code
         *
         * @return bool
         */
        public function verifyRecoveryCode(string $code): bool
        {
            try {
                $recoveryCodes = $this->getRecoveryCodes();

                if (\in_array($code, $recoveryCodes)) {
                    $recoveryCodes = array_replace($recoveryCodes, array_fill_keys(
                        array_keys($recoveryCodes, $code),
                        $this->generateRecoveryCode()
                    ));

                    $this->saveRecoveryCodes($recoveryCodes);

                    return true;
                }
            } catch (DecryptException) {
            }

            return false;
        }

        /**
         * @return string
         */
        private function generateRecoveryCode(): string
        {
            return Str::random(10).'-'.Str::random(10);
        }

        private function saveRecoveryCodes(array $recoveryCodes): void
        {
            $this->security->recovery_codes = Crypt::encrypt($recoveryCodes);
            $this->security->save();
        }
    }
