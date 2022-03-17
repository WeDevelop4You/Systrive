<?php

    namespace App\Admin\System\MailDomain\DataTables;

    use Support\Abstracts\AbstractTable;
    use Support\Helpers\Data\Build\Column;
    use function trans;

    class MailDomainAddressTable extends AbstractTable
    {
        /**
         * @inheritDoc
         */
        protected function structure(): void
        {
            $this->structure = [
                Column::index(),
                Column::create('email', trans('word.email.email'))
                    ->sortable()
                    ->searchable(),
                Column::create('forward_email', trans('word.forward.email'))
                    ->sortable()
                    ->searchable(),
                Column::create('forward_saved', trans('word.forward.saved'))
                    ->sortable()
                    ->searchable(),
                Column::create('usage', trans('word.usage.usage'))
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
