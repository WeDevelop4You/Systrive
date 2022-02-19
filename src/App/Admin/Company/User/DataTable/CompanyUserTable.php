<?php

    namespace App\Admin\Company\User\DataTable;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;

    class CompanyUserTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function columns(): array
        {
            return [
                Column::create('profile.full_name')->sortable(function (Relation|Builder $query, string $direction) {
                    return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                        ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                })->searchable(function (Relation|Builder $query, string $search) {
                    return $query->orWhereHas('profile', function (Relation|Builder $query) use ($search) {
                        return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                    });
                }),
                Column::create('email')->sortable()->searchable(),
                Column::create('status')->sortable()->searchable(CompanyUserStatusTypes::class),
            ];
        }
    }
