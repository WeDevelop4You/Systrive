<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\Models\Company;
    use Domain\Invite\Jobs\SendCompanyInvite;
    use Domain\Invite\Jobs\SendInviteToUser;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;

    class ResendInviteAction
    {
        /**
         * ResendInviteAction constructor.
         *
         * @param Company $company
         */
        public function __construct(
            private Company $company
        ) {
            //
        }

        /**
         * @param Invite $invite
         *
         * @return bool
         */
        public function __invoke(Invite $invite): bool
        {
            switch ($invite->type) {
                case InviteTableMap::USER_TYPE:
                    SendInviteToUser::dispatch($invite->email, $this->company);

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    SendCompanyInvite::dispatch($invite->email, $this->company);

                    break;
                default:
                    return false;
            }

            return true;
        }
    }
