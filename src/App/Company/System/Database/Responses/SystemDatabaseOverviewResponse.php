<?php

namespace App\Company\System\Database\Responses;

use Domain\Company\Models\Company;
use Domain\System\Models\SystemDatabase;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Buttons\IconBtnComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ChartComponent;
use Support\Client\Components\Overviews\ListComponent;
use Support\Client\Components\Overviews\ListItems\ListItemBadgeComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Response;
use Support\Enums\Component\ChartType;
use Support\Enums\Component\IconType;

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
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('Details'))
                            ->setButton(
                                WrapperComponent::create()
                                    ->addComponent(
                                        IconBtnComponent::create()
                                            ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                    )
                            )
                    )
                    ->addBody(
                        ListComponent::create()
                            ->addSubheader(trans('word.database.database'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->database->name),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.username.username'))
                                    ->setValue($this->data->get('DBUSER')),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.type.type'))
                                    ->setValue($this->data->get('TYPE')),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.charset.charset'))
                                    ->setValue($this->data->get('CHARSET')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.general.general'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.create_at'))
                                    ->setValue("{$this->data->get('DATE')} {$this->data->get('TIME')}"),
                                ListItemBadgeComponent::create()
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
                    ->setHeader(
                        CardHeaderComponent::create()->setTitle(trans('word.disk.disk'))
                    )
                    ->addBody(
                        ChartComponent::create()
                            ->setType(ChartType::SYSTEM_USAGES)
                            ->setUrl(route('system.database.usage', [
                                $this->company->id,
                                $this->database->system_id,
                                $this->database->id,
                            ]))
                    )
            );
    }
}
