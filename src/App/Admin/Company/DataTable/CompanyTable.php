<?php

    namespace App\Admin\Company\DataTable;

    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;

    class CompanyTable extends AbstractTable
    {
        /**
         * @return array
         */
        protected function columns(): array
        {
            return [
                Column::create('id')->sortable()->searchable(),
                Column::create('name')->sortable()->searchable(),
                Column::create('email')->sortable()->searchable(),
                Column::create('owner.full_name')->sortable(function (Builder $query, string $direction) {
                    return $query->orderBy(UserProfile::orWhereHas('user', function (Builder $query) {
                        $query->whereHas('companyUser', function (Builder $query) {
                            $query->where('company_user.is_owner', true)
                                ->whereColumn('company_user.company_id', 'companies.id');
                        })->withTrashed();
                    })->selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)"), $direction);
                })->searchable(function (Builder $query, string $search) {
                    return $query->orWhereHas('users', function (Builder $query) use ($search) {
                        $query->where('company_user.is_owner', true)
                            ->whereHas('profile', function (Builder $query) use ($search) {
                                $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                            })->withTrashed();
                    });
                }),
                Column::create('status')->sortable()->searchable(),
                Column::create('created_at')->sortable()->searchable(),
            ];
        }
    }