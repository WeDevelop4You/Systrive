<?php

    namespace Domain\Invite\Observers;

    use Domain\Company\States\CompanyExpiredState;
    use Domain\Company\States\CompanyUserExpiredState;
    use Domain\Invite\Models\Invite;

    class InviteCreatedObserver
    {
        /**
         * @param Invite $invite
         *
         * @return void
         */
        public function created(Invite $invite): void
        {
            $invite->state()->changeStateWhen(CompanyExpiredState::class, CompanyUserExpiredState::class);
        }
    }
