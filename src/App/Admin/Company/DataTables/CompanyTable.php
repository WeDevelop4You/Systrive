<?php

    namespace App\Admin\Company\DataTables;

    use Domain\Company\Enums\CompanyStatusTypes;
    use Domain\Company\Mappings\CompanyTableMap;
    use Domain\Company\Mappings\CompanyUserTableMap;
    use Domain\Company\Models\Company;
    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\UserProfile;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Facades\DB;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\IconTypes;
    use Support\Enums\Vuetify\VuetifyColors;
    use Support\Enums\Vuetify\VuetifyTableAlignmentTypes;
    use Support\Helpers\Data\Build\Column;
    use Support\Response\Actions\RequestAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Buttons\IconButtonComponent;
    use Support\Response\Components\Buttons\MultipleButtonComponent;
    use Support\Response\Components\Icons\IconComponent;
    use Support\Response\Components\Items\ItemBadgeComponent;
    use Support\Response\Components\Utils\TooltipComponent;

    class CompanyTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        public function handle(): array
        {
            return [
                Column::id(),
                Column::create(trans('word.name.name'), 'name')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.email.email'), 'email')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.full_name'), 'full_name', 'owner.full_name')
                    ->setSortable(function (Builder $query, string $direction) {
                        $query->orderBy(UserProfile::orWhereHas('user', function (Builder $query) {
                            $query->whereHas(CompanyTableMap::RELATIONSHIP_COMPANY_USER, function (Builder $query) {
                                $query->where(CompanyUserTableMap::IS_OWNER, true)
                                    ->whereColumn(CompanyUserTableMap::COMPANY_ID, CompanyTableMap::ID);
                            })->withTrashed();
                        })->selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)"), $direction);
                    })
                    ->setSearchable(function (Builder $query, string $search) {
                        $query->orWhereHas(CompanyTableMap::RELATIONSHIP_USERS, function (Builder $query) use ($search) {
                            $query->where(CompanyUserTableMap::IS_OWNER, true)
                                ->whereHas(UserTableMap::RELATIONSHIP_PROFILE, function (Builder $query) use ($search) {
                                    $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                                })->withTrashed();
                        });
                    }),
                Column::create(trans('word.status.status'), 'status')
                    ->setSortable()
                    ->setSearchable(CompanyStatusTypes::class)
                    ->setAlignment(VuetifyTableAlignmentTypes::CENTER)
                    ->setFormat(function (Company $data, string $key) {
                        /** @var CompanyStatusTypes $status */
                        $status = $data->getAttribute($key);

                        return ItemBadgeComponent::create()
                            ->setValue($status->getTranslation())
                            ->setColor($status->getColor())
                            ->setOutlined();
                    }),
                Column::create(trans('word.created_at'), 'created_at')
                    ->setSortable()
                    ->setDivider()
                    ->setSearchable()
                    ->setFormat(function (Company $data, string $key) {
                        return $data->getAttribute($key)->toDatetimeString();
                    }),
                Column::actions()
                    ->setFormat(function (Company $data) {
                        return $this->createActions($data);
                    }),
            ];
        }

        /**
         * @param Company $data
         *
         * @return MultipleButtonComponent
         */
        private function createActions(Company $data): MultipleButtonComponent
        {
            return MultipleButtonComponent::create()
                ->addButtonIf(
                    $data->status === CompanyStatusTypes::EXPIRED,
                    IconButtonComponent::create()
                        ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PAPER_PLANE))
                        ->setColorOnHover(VuetifyColors::PRIMARY)
                        ->setTooltip(
                            TooltipComponent::create()
                                ->setText(trans('word.resend.invite'))
                                ->setTop()
                        )
                        ->setAction(
                            RequestAction::create()
                                ->post(
                                    route('admin.admin.company.invite.resend', [
                                        $data->id,
                                    ])
                                )
                                ->setOnSuccess(
                                    VuexAction::create()->refreshTable('companies')
                                )
                        ),
                )
                ->setButtons([
                    IconButtonComponent::create()
                        ->setIcon(IconComponent::create()->setType(IconTypes::FAS_EYE))
                        ->setColorOnHover(VuetifyColors::INFO)
                        ->setTooltip(
                            TooltipComponent::create()
                                ->setText(trans('word.show.show'))
                                ->setTop()
                        )
                        ->setAction(
                            VuexAction::create()
                                ->dispatch(
                                    'companies/show',
                                    route('admin.admin.company.show', [
                                        $data->id,
                                    ])
                                )
                        ),
                    IconButtonComponent::create()
                        ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PEN))
                        ->setColorOnHover(VuetifyColors::WARNING)
                        ->setTooltip(
                            TooltipComponent::create()
                                ->setText(trans('word.edit.edit'))
                                ->setTop()
                        )
                        ->setAction(
                            VuexAction::create()->dispatch(
                                'companies/edit',
                                route('admin.admin.company.edit', [
                                    $data->id,
                                ])
                            )
                        ),
                    IconButtonComponent::create()
                        ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TRASH))
                        ->setColorOnHover(VuetifyColors::ERROR)
                        ->setTooltip(
                            TooltipComponent::create()
                                ->setText(trans('word.delete.delete'))
                                ->setTop()
                        )
                        ->setAction(
                            RequestAction::create()
                                ->get(route('admin.admin.company.destroy', [
                                    $data->id,
                                ]))
                        ),
                ]);
        }
    }
