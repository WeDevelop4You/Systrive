<?php

    namespace Domain\Company\Actions;

    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;

    class InviteUserToCompanyAction
    {
        public function __construct(
            public Company $company,
        ) {
            //
        }

        public function __invoke(CompanyUserData $companyUserData)
        {
            // TODO: Implement __invoke() method.
        }
    }
