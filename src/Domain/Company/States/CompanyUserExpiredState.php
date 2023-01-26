<?php

namespace Domain\Company\States;

use Domain\Company\Enums\CompanyUserStatusTypes;

class CompanyUserExpiredState extends AbstractCompanyUserState
{
    public function changeState(): void
    {
        $this->toRequest();
    }

    private function toRequest()
    {
        $this->update(CompanyUserStatusTypes::REQUESTED);
    }
}
