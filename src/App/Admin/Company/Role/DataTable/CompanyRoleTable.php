<?php

    namespace App\Admin\Company\Role\DataTable;

    use Domain\Role\Mappings\RoleTableMap;
    use Domain\Role\Models\Role;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\Component\IconType;
    use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
    use Support\Helpers\DataTable\Build\Column;
    use Support\Response\Actions\RequestAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Buttons\IconButtonComponent;
    use Support\Response\Components\Buttons\MultipleButtonComponent;
    use Support\Response\Components\Icons\IconComponent;

    class CompanyRoleTable extends AbstractTable
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
                    $isMainRole = strtolower($data->name) !== RoleTableMap::ROLE_MAIN;

                    return MultipleButtonComponent::create()
                        ->addButtonIf(
                            $canEdit && $isMainRole,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'company/roles/edit',
                                        route('admin.company.role.edit', $params)
                                    )
                                )
                        )
                        ->addButtonIf(
                            $canDelete && $isMainRole,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                ->setAction(
                                    RequestAction::create()
                                        ->get(route('admin.company.role.destroy', $params))
                                )
                        );
                });
            }

            return $structure;
        }
    }
