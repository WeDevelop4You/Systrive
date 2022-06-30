<?php

namespace Domain\Company\states;

use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Models\CompanyUser;
use Domain\Invite\Models\Invite;

class CompanyUserStates
{
    /**
     * CompanyUserStates constructor.
     *
     * @param Invite $invite
     */
    public function __construct(
        protected Invite $invite
    ) {
        //
    }

    /**
     * @param CompanyUserStatusTypes $state
     *
     * @return void
     */
    protected function update(CompanyUserStatusTypes $state): void
    {
        $companyUser = CompanyUser::firstWithInvite($this->invite);

        if ($companyUser instanceof CompanyUser) {
            $companyUser->status = $state;
            $companyUser->save();
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
