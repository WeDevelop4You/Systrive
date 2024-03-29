<?php

namespace App\Company\System\MailDomain\DataTables;

use Support\Abstracts\AbstractTable;
use Support\Client\Components\Misc\BadgeComponent;
use Support\Client\DataTable\Build\Column;

class SystemMailDomainAddressTable extends AbstractTable
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): array
    {
        return [
            Column::index(),
            Column::create(trans('word.email.email'), 'email')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.forward.email'), 'forward_email', 'FWD')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.forward.saved'), 'forward_saved', 'FWD_ONLY')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function ($data, $key) {
                    return BadgeComponent::create()
                        ->setVesta($data[$key]);
                }),
            Column::create(trans('word.usage.usage'), 'usage')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function ($data) {
                    $data = (object) $data;

                    return "{$data->U_DISK} / {$data->QUOTA}";
                }),
            Column::create(trans('word.suspended.suspended'), 'suspended', 'SUSPENDED')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function ($data, $key) {
                    return BadgeComponent::create()
                        ->setVesta($data[$key], true);
                }),
            Column::create(trans('word.created_at'), 'created_at')
                ->setSortable()
                ->setSearchable()
                ->setDivider()
                ->setFormat(function ($data) {
                    $data = (object) $data;

                    return "{$data->DATE} {$data->TIME}";
                }),
            Column::actions(),
        ];
    }
}
