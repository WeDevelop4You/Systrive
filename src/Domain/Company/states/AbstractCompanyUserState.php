<?php

namespace Domain\Company\States;

use Domain\Company\Models\CompanyUser;

abstract class AbstractCompanyUserState extends AbstractState
{
    /**
     * @param AbstractCompanyUserState $state
     *
     * @return void
     */
    protected function update(AbstractCompanyUserState $state): void
    {
        $companyUser = CompanyUser::firstWithInvite($this->invite);

        if ($companyUser instanceof CompanyUser) {
            $companyUser->status = $state;
            $companyUser->save();
        }
    }
}
