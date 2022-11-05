<?php

namespace Domain\Company\States;

use Domain\Company\Enums\CompanyUserStatusTypes;

class CompanyUserRequestedState extends AbstractCompanyUserState
{
    public function changeState(): void
    {
        if ($this->invite->isExpired()) {
            $this->toExpire();
        } else {
            $this->toAccept();
        }
    }

    private function toAccept()
    {
        $this->update(CompanyUserStatusTypes::ACCEPTED);
    }

    private function toExpire()
    {
        $this->update(CompanyUserStatusTypes::EXPIRED);
    }
}
