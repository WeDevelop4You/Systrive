<?php

    namespace App\Admin\Company\Role\DataTable;

    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;

    class CompanyRoleTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function structure(): void
        {
            $showActions = $this->can(
                'role.edit',
                'role.delete',
            );

            $this->structure = [
                Column::index(),
                Column::create('name', trans('word.name.name'))
                    ->sortable()
                    ->searchable(),
                Column::create('permissions_count', trans('word.permission.total'))
                    ->sortable(),
                Column::create('created_at', trans('word.created_at'))
                    ->sortable()
                    ->searchable()
                    ->setDivider($showActions),
            ];

            if ($showActions) {
                $this->structure[] = Column::actions();
            }
        }
    }
