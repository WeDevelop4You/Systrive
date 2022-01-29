<?php

    namespace Domain\Invite\QueryBuilders;

    use Domain\Invite\Mappings\InviteTableMap;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Carbon;

    class InviteQueryBuilders extends Builder
    {
        /**
         * @return InviteQueryBuilders
         */
        public function whereUserType(): InviteQueryBuilders
        {
            return $this->where('type', InviteTableMap::USER_TYPE);
        }

        /**
         * @return InviteQueryBuilders
         */
        public function whereCompanyType(): InviteQueryBuilders
        {
            return $this->where('type', InviteTableMap::COMPANY_TYPE);
        }

        /**
         * @return InviteQueryBuilders
         */
        public function whereExpired(): InviteQueryBuilders
        {
            return $this->where('created_at', '<', Carbon::now()->subDays(7)->toDateTimeString());
        }

        /**
         * @param string      $email
         * @param int         $companyId
         * @param string|null $type
         *
         * @return InviteQueryBuilders
         */
        public function whereInviteByEmailAndCompany(string $email, int $companyId, ?string $type = null): InviteQueryBuilders
        {
            $query = $this->where('email', $email)
                ->where('company_id', $companyId);

            switch ($type) {
                case InviteTableMap::USER_TYPE:
                    $query->whereUserType();

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    $query->whereCompanyType();

                    break;
            }

            return $query;
        }
    }
