<?php

namespace Domain\Company\states;

use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Models\Company;
use Domain\Invite\Models\Invite;

class CompanyStates
{
    /**
     * CompanyStates constructor.
     *
     * @param Invite $invite
     */
    public function __construct(
        protected Invite $invite
    ) {
        //
    }

    /**
     * @param CompanyStatusTypes $state
     *
     * @return void
     */
    protected function update(CompanyStatusTypes $state): void
    {
        $company = $this->invite->company;

        if ($company instanceof Company) {
            $company->status = $state;
            $company->save();
        }
    }

    public function changeState(): void
    {
        //
    }

    /**
     * @param ...$states
     *
     * @return void
     */
    public function changeStateWhen(...$states): void
    {
        if (instanceofArray($this, $states)) {
            $this->changeState();
        }
    }
}
