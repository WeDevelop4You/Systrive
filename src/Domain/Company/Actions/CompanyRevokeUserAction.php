<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Models\Company;
    use Domain\User\Models\User;

    class CompanyRevokeUserAction
    {
        public function __construct(
            public Company $company,
        ) {
            //
        }

        /**
         * @param User $user
         *
         * @return User
         */
        public function __invoke(User $user): User
        {
            $this->company->users()->detach($user->id);

            return $user;
        }
    }
