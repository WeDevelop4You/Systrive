<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompleteCompanyData;
    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Models\Invite;
    use Domain\Role\Actions\CreateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Mappings\RoleTableMap;
    use Illuminate\Support\Facades\Auth;
    use Spatie\Permission\Models\Permission;

    class CompleteCompanyAction
    {
        /**
         * CompleteCompanyAction constructor.
         *
         * @param Company $company
         */
        public function __construct(
            private Company $company
        ) {
        }

        public function __invoke(CompleteCompanyData $completeCompanyData)
        {
            $user = Auth::user();

            $company = $this->company;
            $company->email = $completeCompanyData->email;
            $company->domain = $completeCompanyData->domain;
            $company->information = $completeCompanyData->information;
            $company->status = CompanyTableMap::COMPLETED_STATUS;
            $company->save();

            $company->users()->attach($user, [
                CompanyUserTableMap::STATUS => CompanyUserTableMap::ACCEPTED_STATUS,
                CompanyUserTableMap::IS_OWNER => true,
            ]);

            //TODO create a action to make default roles
            $adminRole = new RoleData(RoleTableMap::MAIN_ROLE, Permission::all()->pluck('id')->toArray());
            (new CreateRoleAction($company))($adminRole);

            Invite::whereInviteByEmailAndCompany($user->email, $company->id)
                ->whereCompanyType()
                ->delete();
        }
    }
