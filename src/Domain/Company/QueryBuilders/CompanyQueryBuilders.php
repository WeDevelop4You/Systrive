<?php

namespace Domain\Company\QueryBuilders;

use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Builder;

class CompanyQueryBuilders extends Builder
{
    /**
     * @param User $user
     *
     * @return CompanyQueryBuilders
     */
    public function whereUser(User $user): CompanyQueryBuilders
    {
        return $this->users()->wherePivot(CompanyUserTableMap::USER_ID, $user->id)->withTrashed();
    }
}
