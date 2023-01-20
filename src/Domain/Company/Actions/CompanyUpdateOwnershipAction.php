<?php

namespace Domain\Company\Actions;

use Domain\Company\DataTransferObjects\CompanyUserData;
use Domain\Company\Models\Company;
use Domain\User\Models\User;

class CompanyUpdateOwnershipAction
{
    /**
     * ChangeCompanyOwnershipAction constructor.
     *
     * @param User|null $oldOwner
     * @param User      $newOwner
     * @param bool      $removeOwner
     */
    public function __construct(
            private readonly ?User $oldOwner,
            private readonly User $newOwner,
            private readonly bool $removeOwner = false
        ) {
            //
    }

    public function __invoke(Company $company): void
    {
        if (! $company->user($this->newOwner)->exists()) {
            $companyUserData = CompanyUserData::createForUser($this->newOwner);

            (new CompanyInviteUserAction($company))($companyUserData);
        }

        $company->giveOwnership($this->newOwner);

        if ($this->oldOwner instanceof User) {
            if ($this->removeOwner) {
                $company->users()->detach($this->oldOwner->id);
            } else {
                $company->removeOwnership($this->oldOwner);
            }
        }
    }
}
