<?php

namespace App\Admin\System\Database\Responses;

use Domain\Company\Models\Company;
use Domain\System\Models\SystemDatabase;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\ChartType;
use Support\Enums\Component\IconType;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemBadgeComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\ChartComponent;
use Support\Response\Components\Overviews\ListComponent;
use Support\Response\Response;

class SystemDatabaseOverviewResponse extends AbstractResponse
{
    /**
     * SystemDatabaseOverviewResponse constructor.
     *
     * @param Company        $company
     * @param SystemDatabase $database
     * @param Collection     $data
     */
    protected function __construct(
        private readonly Company $company,
        private readonly SystemDatabase $database,
        private readonly Collection $data
    ) {
        //
    }

    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                RowComponent::create()
                    ->setCols([
                        $this->createCardList(),
                        $this->createCardDiskUsages(),
                    ])
            );
    }

    /**
     * @return ColComponent
     */
    private function createCardList(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('Details'))
                    ->setHeaderButton(
                        MultipleButtonComponent::create()
                            ->addButton(
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                            )
                    )
                    ->addBody(
                        ListComponent::create()
                            ->addSubheader(trans('word.database.database'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->database->name),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.username.username'))
                                    ->setValue($this->data->get('DBUSER')),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.type.type'))
                                    ->setValue($this->data->get('TYPE')),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.charset.charset'))
                                    ->setValue($this->data->get('CHARSET')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.general.general'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.create_at'))
                                    ->setValue("{$this->data->get('DATE')} {$this->data->get('TIME')}"),
                                ItemBadgeComponent::create()
                                    ->setLabel(trans('word.suspended.suspended'))
                                    ->setVesta($this->data->get('SUSPENDED'), true),
                            ], 2)
                    )
                    ->addAdditionalBodyClass('pa-0')
            );
    }

    /**
     * @return ColComponent
     */
    private function createCardDiskUsages(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.disk.disk'))
                    ->addBody(
                        ChartComponent::create()
                            ->setType(ChartType::SYSTEM_USAGES)
                            ->setUrl(route('admin.system.database.usage', [
                                $this->company->id,
                                $this->database->system_id,
                                $this->database->id,
                            ]))
                    )
            );
    }
}
