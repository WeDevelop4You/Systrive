<?php

namespace Domain\Company\states;

use Domain\Company\Enums\CompanyStatusTypes;

class CompanyInvitedState extends CompanyStates
{
    /**
     * @return void
     */
    public function changeState(): void
    {
        if ($this->invite->isExpired()) {
            $this->toExpire();
        } else {
            $this->toComplete();
        }
    }

    private function toComplete()
    {
        $this->update(CompanyStatusTypes::COMPLETED);
    }

    private function toExpire()
    {
        $this->update(CompanyStatusTypes::EXPIRED);
    }
}
