<?php

    namespace App\Admin\System\DNS\DataTables;

    use Illuminate\Support\Str;
    use Support\Abstracts\AbstractTable;
    use Support\Enums\IconTypes;
    use Support\Helpers\Data\Build\Column;
    use Support\Response\Components\Buttons\IconButtonComponent;
    use Support\Response\Components\Buttons\MultipleButtonComponent;
    use Support\Response\Components\Icons\IconComponent;
    use Support\Response\Components\Items\ItemBadgeComponent;
    use function trans;

    class SystemDNSRecordTable extends AbstractTable
    {
        /**
         * @inheritDoc
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
                        return ItemBadgeComponent::create()
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
                Column::actions()
                    ->setFormat(function ($data) {
                        return MultipleButtonComponent::create()
                            ->setButtons([
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TRASH)),
                            ]);
                    }),
            ];
        }
    }
