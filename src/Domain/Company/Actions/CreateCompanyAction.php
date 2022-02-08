<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\DataTransferObject\CompanyInviteData;
    use Domain\Invite\Jobs\SendCompanyInvite;

    class CreateCompanyAction
    {
        /**
         * @param CompanyInviteData $companyInviteData
         *
         * @return Company
         */
        public function __invoke(CompanyInviteData $companyInviteData): Company
        {
            $company = new Company();
            $company->name = $companyInviteData->name;
            $company->status = CompanyTableMap::INVITED_STATUS;
            $company->save();

            SendCompanyInvite::dispatch($companyInviteData->owner_email, $company);

            return $company;
        }
    }
