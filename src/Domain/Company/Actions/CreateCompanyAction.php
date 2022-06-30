<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\DataTransferObject\CompanyInviteData;
    use Domain\Invite\Jobs\SendCompanyInvite;
    use Domain\Role\Actions\CreateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\User\Actions\CreateUserAction;
    use Spatie\Permission\Models\Permission;

    class CreateCompanyAction
    {
        /**
         * @param CompanyInviteData $companyInviteData
         *
         * @return Company
         */
        public function __invoke(CompanyInviteData $companyInviteData): Company
        {
            $user = (new CreateUserAction())($companyInviteData->email);

            $company = new Company();
            $company->name = $companyInviteData->name;
            $company->status = CompanyStatusTypes::INVITED;
            $company->save();

            $company->users()->attach($user, [
                CompanyUserTableMap::STATUS => CompanyUserStatusTypes::ACCEPTED,
                CompanyUserTableMap::IS_OWNER => true,
            ]);

            //TODO create an action to make default roles
            $adminRole = new RoleData(RoleTableMap::ROLE_MAIN, Permission::all()->pluck('id')->toArray());
            (new CreateRoleAction($company))($adminRole);

            SendCompanyInvite::dispatch($user, $company);

            return $company;
        }
    }
