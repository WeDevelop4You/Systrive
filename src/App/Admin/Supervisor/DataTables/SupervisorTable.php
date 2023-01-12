<?php

namespace App\Admin\Supervisor\DataTables;

use Domain\Supervisor\Models\Supervisor;
use Support\Abstracts\AbstractTable;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;

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
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'supervisor/edit',
                                        route('admin.supervisor.process.edit', [
                                            $data->id,
                                        ])
                                    )
                                ),
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                ->setAction(
                                    RequestAction::create()->get(
                                        route('admin.supervisor.process.destroy', [
                                            $data->id,
                                        ])
                                    )
                                ),
                        ]);
                }),
        ];
    }
}
