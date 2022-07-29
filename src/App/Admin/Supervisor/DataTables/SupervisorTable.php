<?php

namespace App\Admin\Supervisor\DataTables;

use Domain\Supervisor\Models\Supervisor;
use Support\Abstracts\AbstractTable;
use Support\Enums\Component\IconTypes;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;

class SupervisorTable extends AbstractTable
{
    /**
     * @inheritDoc
     */
    protected function handle(): array
    {
        return [
            Column::create(trans('word.name.name'), 'name')
                ->setSortable()
                ->setSearchable(),
            Column::actions()
                ->setFormat(function (Supervisor $data) {
                    return MultipleButtonComponent::create()
                        ->setButtons([
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'supervisor/edit',
                                        route('admin.admin.supervisor.process.edit', [
                                            $data->id,
                                        ])
                                    )
                                ),
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconTypes::FAS_TRASH))
                                ->setAction(
                                    RequestAction::create()->get(
                                        route('admin.admin.supervisor.process.destroy', [
                                            $data->id,
                                        ])
                                    )
                                ),
                        ]);
                }),
        ];
    }
}
