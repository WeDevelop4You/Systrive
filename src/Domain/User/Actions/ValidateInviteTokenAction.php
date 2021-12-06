<?php

    namespace Domain\User\Actions;

    use Domain\Company\Models\Company;
    use Domain\User\Models\UserInvite;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Facades\Hash;
    use Support\Exceptions\InvalidTokenException;

    class ValidateInviteTokenAction
    {
        private Company $company;

        /**
         * @var string
         */
        private string $email;

        /**
         * ValidateInviteTokenAction constructor.
         *
         * @param Company|int $company
         * @param string      $token
         * @param string|null $encryptEmail
         */
        public function __construct(
            Company|int $company,
            private string $token,
            ?string $encryptEmail = null
        ) {
            $this->company = $company instanceof Company
                ? $company
                : Company::findOrFail($company);

            $this->email = is_null($encryptEmail)
                ? Auth::user()->email
                : Crypt::decryptString($encryptEmail);
        }

        /**
         * @throws InvalidTokenException
         *
         * @return UserInvite
         */
        public function __invoke(): UserInvite
        {
            $invite = UserInvite::where('company_id', $this->company->id)
                ->where('email', $this->email)
                ->firstOrFail();

            if ($this->validateToken($invite->created_at, $invite->token)) {
                return $invite;
            }

            throw new InvalidTokenException();
        }

        /**
         * @param string $created_at
         * @param string $token
         *
         * @return bool
         */
        private function validateToken(string $created_at, string $token): bool
        {
            return !$this->tokenExpired($created_at) && Hash::check($this->token, $token);
        }

        /**
         * Determine if the token has expired.
         *
         * @param string $createdAt
         *
         * @return bool
         */
        private function tokenExpired(string $createdAt): bool
        {
            return Carbon::parse($createdAt)->addDays(7)->isPast();
        }
    }
