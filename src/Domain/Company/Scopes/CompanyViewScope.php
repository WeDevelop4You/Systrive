<?php

namespace Domain\Company\Scopes;

use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Enums\CompanyUserStatusTypes;
use Domain\Company\Mappings\CompanyTableMap;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\User\Mappings\UserTableMap;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class CompanyViewScope implements Scope
{
    private const IGNORE_ROUTES = [
        'company.complete',
        'company.invite.link',
        'company.invite.user.accepted',
    ];

    /**
     * {@inheritDoc}
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Request::routeIs(self::IGNORE_ROUTES)) {
            return;
        }

        if (Auth::check()) {
            setCompanyId();

            if (!Auth::user()->isSuperAdmin()) {
                $builder->where(CompanyTableMap::TABLE_STATUS, CompanyStatusTypes::COMPLETED)
                    ->whereHas('users', function (Builder $query) {
                        $query->where(UserTableMap::TABLE_ID, Auth::id())
                            ->where(CompanyUserTableMap::TABLE_STATUS, CompanyUserStatusTypes::ACCEPTED);
                    });
            }

            return;
        }

        throw new ModelNotFoundException();
    }
}
