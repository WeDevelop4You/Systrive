<?php

namespace Domain\Company\States;

use Domain\Company\Enums\CompanyStatusTypes;

class CompanyExpiredState extends AbstractCompanyState
{
    /**
     * @return void
     */
    public function changeState(): void
    {
        $this->toInvite();
    }

    private function toInvite()
    {
        $this->update(CompanyStatusTypes::INVITED);
    }
}
