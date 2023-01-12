<?php

namespace Domain\Company\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class CompanySoftDeletingScope extends SoftDeletingScope
{
    public function apply(Builder $builder, Model $model)
    {
        setCompanyId();

        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            parent::apply($builder, $model);
        }
    }
}
