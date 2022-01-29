<?php

    namespace Domain\Invite\Observers;

    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Invite\Actions\ChangeInviteStatusAction;
    use Domain\Invite\Mappings\InviteTableMap;
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
            switch ($invite->type) {
                case InviteTableMap::USER_TYPE:
                    $oldStatus = CompanyUserTableMap::EXPIRED_STATUS;
                    $newStatus = CompanyUserTableMap::REQUESTED_STATUS;

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    $oldStatus = CompanyTableMap::EXPIRED_STATUS;
                    $newStatus = CompanyTableMap::INVITED_STATUS;

                    break;
                default:
                    return;
            }

            (new ChangeInviteStatusAction($oldStatus, $newStatus))($invite);
        }
    }
