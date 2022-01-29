<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;

    class ChangeInviteStatusAction
    {
        public function __construct(
            private string $oldStatus,
            private string $newStatus,
        ) {
            //
        }

        public function __invoke(Invite $invite)
        {
            switch ($invite->type) {
                case InviteTableMap::USER_TYPE:
                    $this->user($invite);

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    $this->company($invite);

                    break;
            }
        }

        private function user(Invite $invite)
        {
            $user = User::where(UserTableMap::EMAIL, $invite->email)->first();

            if ($user instanceof User) {
                $invite->company
                    ->users()
                    ->wherePivot(CompanyUserTableMap::STATUS, $this->oldStatus)
                    ->updateExistingPivot($user->id, [
                        CompanyUserTableMap::STATUS => $this->newStatus,
                    ]);
            }
        }

        private function company(Invite $invite)
        {
            $company = $invite->company()->where(CompanyTableMap::STATUS, $this->oldStatus)->first();

            if ($company instanceof Company) {
                $company->status = $this->newStatus;
                $company->save();
            }
        }
    }
