<?php

namespace App\Company\System\Dns\DataTables;

use Illuminate\Support\Str;
use Support\Abstracts\AbstractTable;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\BadgeComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;

class SystemDNSRecordTable extends AbstractTable
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): array
    {
        return [
            Column::index(),
            Column::create(trans('word.type.type'), 'type', 'TYPE')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.record.record'), 'record', 'RECORD')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.value.value'), 'value', 'VALUE')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function ($data, $key) {
                    return Str::limit($data[$key], 50);
                }),
            Column::create(trans('word.suspended.suspended'), 'suspended', 'SUSPENDED')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function ($data, $key) {
                    return BadgeComponent::create()->setVesta($data[$key], true);
                }),
            Column::create(trans('word.created_at'), 'created_at')
                ->setSortable()
                ->setSearchable()
                ->setDivider()
                ->setFormat(function ($data) {
                    $data = (object) $data;

                    return "{$data->DATE} {$data->TIME}";
                }),
            Column::actions()
                ->setFormat(function ($data) {
                    return MultipleButtonComponent::create()
                        ->setButtons([
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH)),
                        ]);
                }),
        ];
    }
}
