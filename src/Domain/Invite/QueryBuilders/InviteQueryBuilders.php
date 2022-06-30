<?php

    namespace Domain\Invite\QueryBuilders;

    use Domain\Company\Models\Company;
    use Domain\Invite\Enums\InviteTypes;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Domain\User\QueryBuilders\UserQueryBuilders;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    class InviteQueryBuilders extends Builder
    {
        /**
         * @return InviteQueryBuilders
         */
        public function whereUserType(): InviteQueryBuilders
        {
            return $this->where(InviteTableMap::TYPE, InviteTypes::USER);
        }

        /**
         * @return InviteQueryBuilders
         */
        public function whereCompanyType(): InviteQueryBuilders
        {
            return $this->where(InviteTableMap::TYPE, InviteTypes::COMPANY);
        }

        public function whereType(InviteTypes $type): InviteQueryBuilders
        {
            return match ($type) {
                InviteTypes::USER => $this->whereUserType(),
                InviteTypes::COMPANY => $this->whereCompanyType(),
            };
        }

        /**
         * @return InviteQueryBuilders
         */
        public function whereExpired(): InviteQueryBuilders
        {
            return $this->where(InviteTableMap::CREATED_AT, '<', Carbon::now()->subDays(7)->toDateTimeString());
        }

        /**
         * @param string $email
         *
         * @return InviteQueryBuilders
         */
        public function whereUserByEmail(string $email): InviteQueryBuilders
        {
            return $this->whereHas(InviteTableMap::RELATIONSHIP_USER, function (UserQueryBuilders $query) use ($email) {
                $query->where(UserTableMap::TABLE_EMAIL, $email)->withTrashed();
            });
        }

        /**
         * @param User    $user
         * @param Company $company
         *
         * @return InviteQueryBuilders
         */
        public function whereInviteByUserAndCompany(User $user, Company $company): InviteQueryBuilders
        {
            return $this->where(InviteTableMap::USER_ID, $user->id)
                ->where(InviteTableMap::COMPANY_ID, $company->id);
        }

        /**
         * @param string  $email
         * @param Company $company
         *
         * @return InviteQueryBuilders
         */
        public function whereInviteByEmailAndCompany(string $email, Company $company): InviteQueryBuilders
        {
            return $this->whereUserByEmail($email)->where(InviteTableMap::COMPANY_ID, $company->id);
        }
    }
