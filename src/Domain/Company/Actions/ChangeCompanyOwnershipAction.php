<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Actions\User\InviteUserToCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\Role\Mappings\RoleTableMap;
    use Domain\User\Models\User;

    class ChangeCompanyOwnershipAction
    {
        /**
         * ChangeCompanyOwnershipAction constructor.
         *
         * @param User|null $oldOwner
         * @param User      $newOwner
         * @param bool      $removeUser
         */
        public function __construct(
            private User $newOwner,
            private ?User $oldOwner,
            private bool $removeUser = false
        ) {
            //
        }

        public function __invoke(Company $company)
        {
            if (!$company->whereUser($this->newOwner)->exists()) {
                $companyUserData = new CompanyUserData([RoleTableMap::MAIN_ROLE], [], $this->newOwner->email);

                (new InviteUserToCompanyAction($company))($companyUserData);
            }

            $company->updateOwnership($this->newOwner, true);

            if ($this->oldOwner instanceof User) {
                if ($this->removeUser) {
                    $company->users()->detach($this->oldOwner->id);
                } else {
                    $company->updateOwnership($this->oldOwner);
                }
            }
        }
    }
