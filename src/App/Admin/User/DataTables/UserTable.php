<?php

    namespace App\Admin\User\DataTables;

    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;

    class UserTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function structure(): void
        {
            $this->structure = [
                Column::id(),
                Column::create('profile.full_name', trans('word.full_name'))
                    ->sortable(function (Builder $query, string $direction) {
                        $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                            ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                    })->searchable(function (Builder $query, string $search) {
                        $query->orWhereHas('profile', function (Builder $query) use ($search) {
                            $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                        });
                    }),
                Column::create('email', trans('word.email.email'))
                    ->sortable()
                    ->searchable(),
                Column::create('email_verified_at', trans('word.email_verified_at'))
                    ->sortable()
                    ->searchable(),
                Column::create('created_at', trans('word.created_at'))
                    ->sortable()
                    ->searchable(),
                Column::create('deleted_at', trans('word.deleted_at'))
                    ->sortable()
                    ->setDivider()
                    ->searchable(),
                Column::actions(),
            ];
        }
    }
