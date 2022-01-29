<?php

    namespace Domain\Company\Actions\User;

    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Models\Invite;
    use Domain\User\Models\User;

    class UserInviteToCompanyAcceptedAction
    {
        /**
         * UserInviteToCompanyAcceptedAction constructor.
         *
         * @param User $user
         */
        public function __construct(
            private User $user
        ) {
            //
        }

        /**
         * @param Company $company
         *
         * @return void
         */
        public function __invoke(Company $company): void
        {
            $company->users()->updateExistingPivot($this->user->id, ['status' => CompanyUserTableMap::ACCEPTED_STATUS]);

            Invite::whereInviteByEmailAndCompany($this->user->email, $company->id)
                ->whereUserType()
                ->delete();
        }
    }
