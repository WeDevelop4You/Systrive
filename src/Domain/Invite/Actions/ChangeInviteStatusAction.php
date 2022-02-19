<?php

    namespace Domain\Invite\Actions;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Domain\User\Models\User;

    class ChangeInviteStatusAction
    {
        public function __construct(
            private CompanyStatusTypes|CompanyUserStatusTypes $oldStatus,
            private CompanyStatusTypes|CompanyUserStatusTypes $newStatus,
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
            if ($invite->user instanceof User) {
                $invite->company
                    ->users()
                    ->wherePivot(CompanyUserTableMap::STATUS, $this->oldStatus->value)
                    ->updateExistingPivot($invite->user->id, [
                        CompanyUserTableMap::STATUS => $this->newStatus->value,
                    ]);
            }
        }

        private function company(Invite $invite)
        {
            $company = $invite->company->where(CompanyTableMap::STATUS, $this->oldStatus)->first();

            if ($company instanceof Company) {
                $company->status = $this->newStatus;
                $company->save();
            }
        }
    }
