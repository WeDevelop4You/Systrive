<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Enums\CompanyStatusTypes;
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
            $company->status = CompanyStatusTypes::INVITED;
            $company->save();

            SendCompanyInvite::dispatch($companyInviteData->owner_email, $company);

            return $company;
        }
    }
