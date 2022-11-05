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
         * @param string    $newOwnerEmail
         * @param bool      $removeOwner
         */
        public function __construct(
            private ?User $oldOwner,
            private string $newOwnerEmail,
            private bool $removeOwner = false
        ) {
            //
        }

        public function __invoke(Company $company)
        {
            $newOwner = $company->whereUserByEmail($this->newOwnerEmail)->first();

            if (\is_null($newOwner)) {
                $companyUserData = new CompanyUserData([], [], $this->newOwnerEmail);

                $newOwner = (new CompanyUserStoreInviteAction($company))($companyUserData);
            }

            $company->updateOwnership($newOwner, true);

            if ($this->oldOwner instanceof User) {
                if ($this->removeOwner) {
                    $company->users()->detach($this->oldOwner->id);
                } else {
                    $company->updateOwnership($this->oldOwner);
                }
            }
        }
    }
