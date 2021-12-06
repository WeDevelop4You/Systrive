<?php

    namespace Domain\Company\Actions;

    use Domain\Company\Models\Company;
    use Domain\User\Models\User;
    use Domain\User\Models\UserInvite;

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
            UserInvite::deleteExisting($this->user->email, $company->id);

            $company->users()->updateExistingPivot($this->user->id, ['status' => UserInvite::INVITE_USER_ACCEPTED]);
        }
    }
