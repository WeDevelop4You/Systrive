<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyInviteData;
    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Jobs\SendCompanyInvite;
    use Domain\Role\Actions\CreateRoleAction;
    use Domain\Role\DataTransferObjects\RoleData;
    use Domain\Role\Seeders\RoleSeeder;
    use Illuminate\Support\Arr;

    class CompanyInviteAction
    {
        /**
         * @param CompanyInviteData $companyCreateData
         *
         * @return Company
         */
        public function __invoke(CompanyInviteData $companyCreateData): Company
        {
            $company = new Company();
            $company->name = $companyCreateData->name;
            $company->status = CompanyStatusTypes::INVITED;
            $company->modules = $companyCreateData->modules->mapWithKeys(function (array $data, string $module) {
                return [$module => Arr::get($data, 'value', false)];
            });
            $company->save();

            $company->users()->attach($companyCreateData->owner, [
                CompanyUserTableMap::COL_STATUS => CompanyUserStatusTypes::ACCEPTED,
                CompanyUserTableMap::COL_IS_OWNER => true,
            ]);

            RoleSeeder::create()->each(fn (RoleData $role) => (new CreateRoleAction($company))($role));

            SendCompanyInvite::dispatch($companyCreateData->owner, $company);

            return $company;
        }
    }
