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
    use Domain\Role\Seeders\RoleSeeder;
    use Domain\User\Actions\CreateUserAction;
    use Illuminate\Support\Arr;
    use Spatie\Permission\Models\Permission;

    class CompanyStoreAction
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
            $company->modules = $companyInviteData->modules->mapWithKeys(function (array $data, string $module) {
                return [$module => Arr::get($data, 'value', false)];
            });
            $company->save();

            $company->users()->attach($user, [
                CompanyUserTableMap::STATUS => CompanyUserStatusTypes::ACCEPTED,
                CompanyUserTableMap::IS_OWNER => true,
            ]);

            RoleSeeder::create()->each(fn(RoleData $role) => (new CreateRoleAction($company))($role));

            SendCompanyInvite::dispatch($user, $company);

            return $company;
        }
    }
