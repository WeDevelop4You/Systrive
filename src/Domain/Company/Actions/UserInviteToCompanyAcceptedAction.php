<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Domain\Invite\Models\Invite;

    class UserInviteToCompanyAcceptedAction
    {
        /**
         * UserInviteToCompanyAcceptedAction constructor.
         *
         * @param User $user
         */
        public function __construct(
            private User $user
        ) {
            //
        }

        /**
         * @param Company $company
         *
         * @return void
         */
        public function __invoke(Company $company): void
        {
            Invite::deleteExisting($this->user->email, $company->id, Invite::COMPANY_USER_TYPE);

            if ($this->user->trashed()) {
                $this->user->restore();
            }

            $company->users()->updateExistingPivot($this->user->id, ['status' => Invite::COMPANY_USER_ACCEPTED]);
        }
    }
