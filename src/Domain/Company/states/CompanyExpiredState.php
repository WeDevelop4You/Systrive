<?php

namespace Domain\Company\states;

use Domain\Company\Enums\CompanyStatusTypes;

class CompanyExpiredState extends CompanyStates
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
