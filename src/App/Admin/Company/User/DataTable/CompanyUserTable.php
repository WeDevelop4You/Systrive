<?php

    namespace App\Admin\Company\User\DataTable;

    use Domain\Company\Enums\CompanyUserStatusTypes;
    use Domain\Company\Models\CompanyUser;
    use Domain\User\Models\User;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Relations\Relation;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\Component\IconType;
    use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
    use Support\Helpers\DataTable\Build\Column;
    use Support\Response\Actions\RequestAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Buttons\IconButtonComponent;
    use Support\Response\Components\Buttons\MultipleButtonComponent;
    use Support\Response\Components\Icons\IconComponent;
    use Support\Response\Components\Items\ItemBadgeComponent;

    class CompanyUserTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function handle(): array
        {
            $canInvite = $this->can('user.invite');
            $canRevoke = $this->can('user.revoke');
            $canEdit = $this->can('user.edit_roles');

            $showActions = $canInvite || $canRevoke || $canEdit;

            $structure = [
                Column::index(),
                Column::create(trans('word.full_name'), 'full_name', 'profile.full_name')
                    ->setSortable(function (Relation|Builder $query, string $direction) {
                        return $query->orderBy(UserProfile::selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)")
                            ->whereColumn('users.id', 'user_profiles.user_id'), $direction);
                    })
                    ->setSearchable(function (Relation|Builder $query, string $search) {
                        return $query->orWhereHas('profile', function (Relation|Builder $query) use ($search) {
                            return $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                        });
                    }),
                Column::create(trans('word.email.email'), 'email')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.status.status'), 'status')
                    ->setSortable()
                    ->setDivider($showActions)
                    ->setSearchable(CompanyUserStatusTypes::class)
                    ->setAlignment(VuetifyTableAlignmentType::CENTER)
                    ->setFormat(function (User $data) {
                        /** @var CompanyUserStatusTypes $status */
                        $status = $data->pivot->status;

                        return ItemBadgeComponent::create()
                            ->setValue($status->getTranslation())
                            ->setColor($status->getColor())
                            ->setOutlined();
                    }),
            ];

            if ($showActions) {
                $structure[] = Column::actions()->setFormat(function (User $data) use (
                    $canEdit,
                    $canInvite,
                    $canRevoke,
                ) {
                    /** @var CompanyUser $pivot */
                    $pivot = $data->pivot;
                    $params = [$pivot->company_id, $data->id];

                    return MultipleButtonComponent::create()
                        ->addButtonIf(
                            $pivot->status === CompanyUserStatusTypes::EXPIRED && $canInvite,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PAPER_PLANE))
                                ->setAction(
                                    RequestAction::create()
                                        ->post(route('admin.company.user.invite.resend', $params))
                                        ->setOnSuccessAction(
                                            VuexAction::create()->refreshTable('company/users')
                                        )
                                ),
                        )->addButtonIf(
                            $canEdit && ($pivot->is_owner || $data->id !== Auth::id()),
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        "company/users/edit",
                                        route('admin.company.user.edit', $params)
                                    )
                                )
                        )->addButtonIf(
                            !$pivot->is_owner && $canRevoke,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_USER_MINUS))
                                ->setAction(
                                    RequestAction::create()
                                        ->get(route('admin.company.user.revoke', $params))
                                )
                        );
                });
            }

            return $structure;
        }
    }
