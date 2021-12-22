<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyData;
    use Domain\Company\Jobs\SendCompanyInvite;
    use Domain\Company\Models\Company;
    use Domain\User\Jobs\SendInviteToUser;
    use Domain\Invite\Models\Invite;

    class CreateCompanyAction
    {
        /**
         * @param CompanyData $companyData
         *
         * @return Company
         */
        public function __invoke(CompanyData $companyData): Company
        {
            $company = new Company();
            $company->name = $companyData->name;
            $company->email = $companyData->email;
            $company->save();

            SendCompanyInvite::dispatch($companyData->email, $company);

            return $company;
        }
    }
