<?php

    namespace Domain\Invite\Observers;

    use Domain\Company\states\CompanyExpiredState;
    use Domain\Company\states\CompanyUserExpiredState;
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
            $invite->type->getStatus($invite)
                ->changeStateWhen(CompanyExpiredState::class, CompanyUserExpiredState::class);
        }
    }
