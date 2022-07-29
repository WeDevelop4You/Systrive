<?php

namespace Domain\Company\states;

use Domain\Company\Enums\CompanyUserStatusTypes;

class CompanyUserExpiredState extends CompanyUserStates
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
