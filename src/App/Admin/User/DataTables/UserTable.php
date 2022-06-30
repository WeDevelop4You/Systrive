<?php

    namespace App\Admin\User\DataTables;

    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\IconTypes;
    use Support\Helpers\Data\Build\Column;
    use Support\Response\Actions\RequestAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Buttons\IconButtonComponent;
    use Support\Response\Components\Buttons\MultipleButtonComponent;
    use Support\Response\Components\Icons\IconComponent;

    class UserTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function handle(): array
        {
            return [
                Column::id(),
                Column::create(trans('word.full_name'), 'full_name', 'profile.full_name')
                    ->setSortable(function (Builder $query, string $direction) {
                        $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                            ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                    })->setSearchable(function (Builder $query, string $search) {
                        $query->orWhereHas('profile', function (Builder $query) use ($search) {
                            $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                        });
                    }),
                Column::create(trans('word.email.email'), 'email')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.email_verified_at'), 'email_verified_at')
                    ->setSortable()
                    ->setSearchable()
                    ->setFormat(function (User $data, string $key) {
                        return $data->getAttribute($key)?->toDatetimeString();
                    }),
                Column::create(trans('word.created_at'), 'created_at')
                    ->setSortable()
                    ->setSearchable()
                    ->setFormat(function (User $data, string $key) {
                        return $data->getAttribute($key)->toDatetimeString();
                    }),
                Column::create(trans('word.deleted_at'), 'deleted_at')
                    ->setSortable()
                    ->setDivider()
                    ->setSearchable()
                    ->setFormat(function (User $data, string $key) {
                        return $data->getAttribute($key)?->toDatetimeString();
                    }),
                Column::actions()
                    ->setFormat(function (User $data) {
                        return MultipleButtonComponent::create()
                            ->setButtons([
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PEN))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'users/edit',
                                            route('admin.admin.user.edit', [
                                                $data->id,
                                            ])
                                        )
                                    ),
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TRASH))
                                    ->setAction(
                                        RequestAction::create()
                                            ->get(route('admin.admin.user.destroy', [
                                                $data->id,
                                            ]))
                                    ),
                            ]);
                    }),
            ];
        }
    }
