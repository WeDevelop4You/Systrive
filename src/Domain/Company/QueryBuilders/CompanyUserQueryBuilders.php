<?php

namespace Domain\Company\QueryBuilders;

use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\CompanyUser;
use Domain\Invite\Models\Invite;
use Illuminate\Database\Eloquent\Builder;

class CompanyUserQueryBuilders extends Builder
{
    /**
     * @param Invite $invite
     *
     * @return CompanyUser|null
     */
    public function firstWithInvite(Invite $invite): CompanyUser|null
    {
        return $this->where(CompanyUserTableMap::USER_ID, $invite->user_id)
            ->where(CompanyUserTableMap::COMPANY_ID, $invite->company_id)
            ->first();
    }
}
