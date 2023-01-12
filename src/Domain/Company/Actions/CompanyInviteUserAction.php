<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Jobs\SendInviteToUser;

    class CompanyInviteUserAction
    {
        /**
         * CompanyInviteUserAction constructor.
         *
         * @param Company $company
         */
        public function __construct(
            private readonly Company $company,
        ) {
            //
        }

        /**
         * @param CompanyUserData $companyUserData
         *
         * @return void
         */
        public function __invoke(CompanyUserData $companyUserData): void
        {
            (new CompanyUpdateUserPermissionsAction($this->company))($companyUserData);

            $this->company->users()->attach($companyUserData->user, [
                CompanyUserTableMap::COL_STATUS => CompanyUserStatusTypes::REQUESTED,
            ]);

            SendInviteToUser::dispatch($companyUserData->user, $this->company);
        }
    }
