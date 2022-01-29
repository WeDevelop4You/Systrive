<?php

    namespace Domain\Company\Actions\User;

    use Carbon\Carbon;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Jobs\SendInviteToUser;
    use Domain\User\Models\User;

    class InviteUserToCompanyAction
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
            $user = User::withTrashed()->whereEmail($companyUserData->email)->firstOrNew();

            if (!$user->exists) {
                $user->email = $companyUserData->email;
                $user->deleted_at = Carbon::now();
                $user->save();
            }

            (new UserPermissionsForCompanyAction($this->company, $user))($companyUserData);

            $this->company->users()->attach($user->id, ['status' => CompanyUserTableMap::REQUESTED_STATUS]);

            SendInviteToUser::dispatch($user, $this->company);

            return $user;
        }
    }
