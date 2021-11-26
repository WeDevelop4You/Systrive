<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    class InviteUserToCompanyAction
    {
        public function __construct(
            public Company $company,
        ) {
            //
        }

        /**
         * @param CompanyUserData $companyUserData
         *
         * @return User
         */
        public function __invoke(CompanyUserData $companyUserData): User
        {
            $user = User::whereEmail($companyUserData->email)->firstOrNew();

            if (!$user->exists) {
                $user->email = $companyUserData->email;
                $user->save();
            }

            $this->company->users()->attach($user->id);

            (new UserPermissionsForCompanyAction($this->company, $user))($companyUserData);

            // TODO write invite email

            return $user;
        }
    }
