<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Actions\User\InviteUserToCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Models\User;

    class ChangeCompanyOwnershipAction
    {
        /**
         * ChangeCompanyOwnershipAction constructor.
         *
         * @param User|null $oldOwner
         * @param string    $newOwnerEmail
         * @param bool      $removeUser
         */
        public function __construct(
            private ?User $oldOwner,
            private string       $newOwnerEmail,
            private bool         $removeUser = false
        ) {
            //
        }

        public function __invoke(Company $company)
        {
            $newOwner = $company->whereUserEmail($this->newOwnerEmail)->first();

            if (is_null($newOwner)) {
                $companyUserData = new CompanyUserData([], [], $this->newOwnerEmail);

                $newOwner = (new InviteUserToCompanyAction($company))($companyUserData);
            }

            $company->updateOwnership($newOwner, true);

            if ($this->oldOwner instanceof User) {
                if ($this->removeUser) {
                    $company->users()->detach($this->oldOwner->id);
                } else {
                    $company->updateOwnership($this->oldOwner);
                }
            }
        }
    }
