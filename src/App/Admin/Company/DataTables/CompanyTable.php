<?php

    namespace App\Admin\Company\DataTables;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\Vuetify\VuetifyTableAlignmentTypes;
    use Support\Helpers\Data\Build\Column;

    class CompanyTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        public function structure(): void
        {
            $this->structure = [
                Column::id(),
                Column::create('name', trans('word.name.name'))
                    ->sortable()
                    ->searchable(),
                Column::create('email', trans('word.email.email'))
                    ->sortable()
                    ->searchable(),
                Column::create('owner.full_name', trans('word.full_name'))
                    ->sortable(function (Builder $query, string $direction) {
                        $query->orderBy(UserProfile::orWhereHas('user', function (Builder $query) {
                            $query->whereHas('companyUser', function (Builder $query) {
                                $query->where('company_user.is_owner', true)
                                    ->whereColumn('company_user.company_id', 'companies.id');
                            })->withTrashed();
                        })->selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)"), $direction);
                    })
                    ->searchable(function (Builder $query, string $search) {
                        $query->orWhereHas('users', function (Builder $query) use ($search) {
                            $query->where('company_user.is_owner', true)
                                ->whereHas('profile', function (Builder $query) use ($search) {
                                    $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                                })->withTrashed();
                        });
                    }),
                Column::create('status', trans('word.status.status'))
                    ->sortable()
                    ->searchable(CompanyStatusTypes::class)
                    ->setAlignment(VuetifyTableAlignmentTypes::CENTER),
                Column::create('created_at', trans('word.created_at'))
                    ->sortable()
                    ->setDivider()
                    ->searchable(),
                Column::actions(),
            ];
        }
    }
