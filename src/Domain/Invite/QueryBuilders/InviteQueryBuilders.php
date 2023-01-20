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
    public function whereType(InviteTypes $type): InviteQueryBuilders
    {
        return match ($type) {
            InviteTypes::USER => $this->whereTypeUser(),
            InviteTypes::COMPANY => $this->whereTypeCompany(),
        };
    }

    /**
     * @return InviteQueryBuilders
     */
    public function whereTypeUser(): InviteQueryBuilders
    {
        return $this->where(InviteTableMap::COL_TYPE, InviteTypes::USER);
    }

    /**
     * @return InviteQueryBuilders
     */
    public function whereTypeCompany(): InviteQueryBuilders
    {
        return $this->where(InviteTableMap::COL_TYPE, InviteTypes::COMPANY);
    }

    /**
     * @return InviteQueryBuilders
     */
    public function whereExpired(): InviteQueryBuilders
    {
        return $this->where(InviteTableMap::COL_CREATED_AT, '<', Carbon::now()->subDays(7)->toDateTimeString());
    }

    /**
     * @param string $email
     *
     * @return InviteQueryBuilders
     */
    public function whereUserByEmail(string $email): InviteQueryBuilders
    {
        return $this->whereHas(InviteTableMap::RELATION_USER, function (UserQueryBuilders $query) use ($email) {
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
        return $this->where(InviteTableMap::COL_USER_ID, $user->id)
            ->where(InviteTableMap::COL_COMPANY_ID, $company->id);
    }

    /**
     * @param string  $email
     * @param Company $company
     *
     * @return InviteQueryBuilders
     */
    public function whereInviteByEmailAndCompany(string $email, Company $company): InviteQueryBuilders
    {
        return $this->whereUserByEmail($email)->where(InviteTableMap::COL_COMPANY_ID, $company->id);
    }
}
