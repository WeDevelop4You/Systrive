<?php

    namespace App\Admin\User\DataTable;

    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;

    class UserTable extends AbstractTable
    {
        /**
         * @return array
         */
        protected function columns(): array
        {
            return [
                Column::create('id')->sortable()->searchable(),
                Column::create('profile.full_name')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                        ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('profile', function (Builder $query) use ($search) {
                        return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                    });
                }),
                Column::create('email')->sortable()->searchable(),
                Column::create('email_verified_at')->sortable()->searchable(),
                Column::create('created_at')->sortable()->searchable(),
                Column::create('deleted_at')->sortable()->searchable(),
            ];
        }
    }
