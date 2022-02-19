<?php

    namespace Domain\Invite\Observers;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Enums\CompanyUserStatusTypes;
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
                    $oldStatus = CompanyUserStatusTypes::EXPIRED;
                    $newStatus = CompanyUserStatusTypes::REQUESTED;

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    $oldStatus = CompanyStatusTypes::EXPIRED;
                    $newStatus = CompanyStatusTypes::INVITED;

                    break;
                default:
                    return;
            }

            (new ChangeInviteStatusAction($oldStatus, $newStatus))($invite);
        }
    }
