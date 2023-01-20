<?php

namespace Domain\Company\Actions;

use Domain\Company\DataTransferObjects\CompleteCompanyData;
use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Models\Company;
use Domain\Invite\Models\Invite;
use Illuminate\Support\Facades\Auth;

class CompanyCompleteAction
{
    /**
     * CompleteCompanyAction constructor.
     *
     * @param Company $company
     */
    public function __construct(
            private readonly Company $company
        ) {
            //
    }

    /**
     * @param CompleteCompanyData $completeCompanyData
     *
     * @return Company
     */
    public function __invoke(CompleteCompanyData $completeCompanyData): Company
    {
        $company = $this->company;
        $company->email = $completeCompanyData->email;
        $company->domain = $completeCompanyData->domain;
        $company->status = CompanyStatusTypes::COMPLETED;
        $company->save();

        Invite::whereInviteByUserAndCompany(Auth::user(), $company)->whereTypeCompany()->delete();

        return $company;
    }
}
