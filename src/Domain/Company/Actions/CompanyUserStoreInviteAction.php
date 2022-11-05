<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Jobs\SendInviteToUser;
    use Domain\User\Actions\CreateUserAction;
    use Domain\User\Models\User;

    class CompanyUserStoreInviteAction
    {
        /**
         * InviteUserToCompanyAction constructor.
         *
         * @param Company $company
         */
        public function __construct(
            private Company $company,
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
            $user = (new CreateUserAction())($companyUserData->email);

            (new CompanyUserUpdatePermissionsAction($this->company, $user))($companyUserData);

            $this->company->users()->attach($user->id, [
                CompanyUserTableMap::STATUS => CompanyUserStatusTypes::REQUESTED,
            ]);

            SendInviteToUser::dispatch($user, $this->company);

            return $user;
        }
    }
