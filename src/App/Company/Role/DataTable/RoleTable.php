<?php

    namespace App\Company\Role\DataTable;

    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Support\Abstracts\AbstractTable;
    use Support\Client\Actions\RequestAction;
    use Support\Client\Actions\VuexAction;
    use Support\Client\Components\Buttons\IconButtonComponent;
    use Support\Client\Components\Buttons\MultipleButtonComponent;
    use Support\Client\Components\Misc\Icons\IconComponent;
    use Support\Client\DataTable\Build\Column;
    use Support\Enums\Component\IconType;
    use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
    use Support\Helpers\VuexNamespaceHelper;

    class RoleTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function handle(): array
        {
            $canEdit = $this->can('role.edit');
            $canDelete = $this->can('role.delete');

            $showActions = $canEdit || $canDelete;

            $structure = [
                Column::index(),
                Column::create(trans('word.name.name'), 'name')
                    ->setSortable()
                    ->setSearchable(),
                Column::create(trans('word.permission.total'), 'permissions_count')
                    ->setSortable()
                    ->setAlignment(VuetifyTableAlignmentType::CENTER),
                Column::create(trans('word.created_at'), 'created_at')
                    ->setSortable()
                    ->setSearchable()
                    ->setDivider($showActions)
                    ->setFormat(function (Role $data, string $key) {
                        return $data->getAttribute($key)->toDatetimeString();
                    }),
            ];

            if ($showActions) {
                $structure[] = Column::actions()->setFormat(function (Role $data) use (
                    $canEdit,
                    $canDelete
                ) {
                    $params = [$data->company_id, $data->id];
                    $isMainRole = $data->name !== RoleTableMap::ROLE_MAIN;

                    return MultipleButtonComponent::create()
                        ->addButtonIf(
                            $canEdit && $isMainRole,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        VuexNamespaceHelper::createCompanyWhenAdmin('roles/edit'),
                                        route('company.role.edit', $params)
                                    )
                                )
                        )
                        ->addButtonIf(
                            $canDelete && $isMainRole,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                ->setAction(
                                    RequestAction::create()
                                        ->get(route('company.role.destroy', $params))
                                )
                        );
                });
            }

            return $structure;
        }
    }
