<?php

namespace Domain\Invite\Actions;

use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\Company;
use Domain\Invite\Models\Invite;
use Domain\User\Models\User;

class CompanyUserUpdateInviteToAcceptedAction
{
    /**
     * UserInviteToCompanyAcceptedAction constructor.
     *
     * @param User $user
     */
    public function __construct(
            private User $user
        ) {
            //
    }

    /**
     * @param Company $company
     *
     * @return void
     */
    public function __invoke(Company $company): void
    {
        $company->users()->updateExistingPivot($this->user->id, [
            CompanyUserTableMap::COL_STATUS => CompanyUserStatusTypes::ACCEPTED->value,
        ]);

        Invite::whereInviteByUserAndCompany($this->user, $company)
            ->whereTypeUser()
            ->delete();
    }
}
