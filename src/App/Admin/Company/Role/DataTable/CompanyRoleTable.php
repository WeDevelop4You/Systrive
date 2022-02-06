<?php

    namespace App\Admin\Company\Role\DataTable;

    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;

    class CompanyRoleTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function columns(): array
        {
            return [
                Column::create('name')->sortable()->searchable(),
                Column::create('permissions_count')->sortable(),
                Column::create('created_at')->sortable()->searchable(),
            ];
        }
    }
