<?php

    namespace App\Admin\System\DNS\DataTables;

    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;
    use function trans;

    class DNSRecordTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function structure(): void
        {
            $this->structure = [
                Column::id(),
                Column::create('type', trans('word.type.type'))
                    ->sortable()
                    ->searchable(),
                Column::create('record', trans('word.record.record'))
                    ->sortable()
                    ->searchable(),
                Column::create('value', trans('word.value.value'))
                    ->sortable()
                    ->searchable(),
                Column::create('suspended', trans('word.suspended.suspended'))
                    ->sortable()
                    ->searchable(),
                Column::create('created_at', trans('word.created_at'))
                    ->sortable()
                    ->searchable()
                    ->setDivider(),
                Column::actions(),
            ];
        }
    }
