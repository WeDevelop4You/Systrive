<?php

    namespace Domain\User\Actions;

    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Domain\User\Models\UserInvite;
    use Exception;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Facades\Hash;
    use Support\Exceptions\InvalidTokenException;

    class ValidateInviteTokenAction
    {
        private string $email;

        /**
         * ValidateInviteTokenAction constructor.
         *
         * @param Company $company
         * @param string  $token
         * @param string  $encryptEmail
         *
         * @throws DecryptException
         */
        public function __construct(
            private Company $company,
            private string $token,
            string $encryptEmail
        ) {
            $this->email = Crypt::decryptString($encryptEmail);
        }

        /**
         * @throws InvalidTokenException|ModelNotFoundException
         * @return bool
         */
        public function __invoke(): bool
        {
            $invite = UserInvite::where('company_id', $this->company->id)
                ->where('email', $this->email)
                ->firstOrFail();

            if ($this->validateToken($invite->created_at, $invite->token)) {
                return User::where('email', $this->email)->whereNull('password')->exists();
            }

            throw new InvalidTokenException();
        }

        /**
         * @param Carbon $created_at
         * @param string $token
         *
         * @return bool
         */
        private function validateToken(Carbon $created_at, string $token): bool
        {
            return !$this->tokenExpired($created_at) && Hash::check($this->token, $token);
        }

        /**
         * Determine if the token has expired.
         *
         * @param Carbon $createdAt
         *
         * @return bool
         */
        private function tokenExpired(Carbon $createdAt): bool
        {
            return $createdAt->addDays(7)->isPast();
        }
    }
