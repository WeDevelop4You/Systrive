<?php

    namespace Domain\User\QueryBuilders;

    use Illuminate\Database\Eloquent\Builder;

    class UserInviteQueryBuilders extends Builder
    {
        /**
         * @param string $email
         * @param int    $companyId
         *
         * @return mixed
         */
        public function deleteExisting(string $email, int $companyId): mixed
        {
            return $this->where('email', $email)->where('company_id', $companyId)->delete();
        }
    }
