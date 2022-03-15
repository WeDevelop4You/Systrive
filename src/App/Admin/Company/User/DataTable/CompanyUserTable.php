<?php

    namespace App\Admin\Company\User\DataTable;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\Vuetify\VuetifyTableAlignmentTypes;
    use Support\Helpers\Data\Build\Column;

    class CompanyUserTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function structure(): void
        {
            $showActions = $this->can(
                'user.invite',
                'user.revoke',
                'user.edit_roles',
            );

            $this->structure = [
                Column::create('profile.full_name', trans('word.full_name'))
                    ->sortable(function (Relation|Builder $query, string $direction) {
                        return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                            ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                    })
                    ->searchable(function (Relation|Builder $query, string $search) {
                        return $query->orWhereHas('profile', function (Relation|Builder $query) use ($search) {
                            return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                        });
                    }),
                Column::create('email', trans('word.email.email'))
                    ->sortable()
                    ->searchable(),
                Column::create('status', trans('word.status.status'))
                    ->sortable()
                    ->setDivider($showActions)
                    ->searchable(CompanyUserStatusTypes::class)
                    ->setAlignment(VuetifyTableAlignmentTypes::CENTER),
            ];

            if ($showActions) {
                $this->structure[] = Column::actions();
            }
        }
    }
