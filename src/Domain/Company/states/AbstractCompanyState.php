<?php

namespace Domain\Company\States;

use Domain\Company\Models\Company;

abstract class AbstractCompanyState extends AbstractState
{
    /**
     * @param AbstractCompanyState $state
     *
     * @return void
     */
    protected function update(AbstractCompanyState $state): void
    {
        $company = $this->invite->company;

        if ($company instanceof Company) {
            $company->status = $state;
            $company->save();
        }
    }
}
