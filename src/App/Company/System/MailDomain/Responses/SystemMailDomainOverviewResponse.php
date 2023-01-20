<?php

namespace App\Company\System\MailDomain\Responses;

use Domain\Company\Models\Company;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ChartComponent;
use Support\Client\Components\Overviews\ListComponent;
use Support\Client\Components\Overviews\ListItems\ListItemBadgeComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Components\Overviews\Tables\LocaleTableComponent;
use Support\Client\Response;
use Support\Enums\Component\ChartType;
use Support\Enums\Component\IconType;

class SystemMailDomainOverviewResponse extends AbstractResponse
{
    protected function __construct(
        private readonly Company $company,
        private readonly SystemMailDomain $mailDomain,
        private readonly Collection $data
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                RowComponent::create()
                    ->setCols([
                        $this->createCardList(),
                        $this->createCardDiskUsages(),
                        $this->createTable(),
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
                            ->setTitle(trans('word.details'))
                            ->setButton(
                                MultipleButtonComponent::create()
                                    ->addButton(
                                        IconButtonComponent::create()
                                            ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                    )
                            )
                    )
                    ->addBody(
                        ListComponent::create()
                            ->addSubheader(trans('word.domain.domain'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->mailDomain->name),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.catch.all'))
                                    ->setValue($this->data->get('CATCHALL')),
                                ListItemBadgeComponent::create()
                                    ->setLabel(trans('word.anti.virus'))
                                    ->setVesta($this->data->get('ANTIVIRUS')),
                                ListItemBadgeComponent::create()
                                    ->setLabel(trans('word.anti.spam'))
                                    ->setVesta($this->data->get('ANTISPAM')),
                                ListItemBadgeComponent::create()
                                    ->setLabel(trans('word.dkim.dkim'))
                                    ->setVesta($this->data->get('DKIM')),
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
                            ->setUrl(route('system.mail.domain.usage', [
                                $this->company->id,
                                $this->mailDomain->system_id,
                                $this->mailDomain->id,
                            ]))
                    )
            );
    }

    /**
     * @return ColComponent
     */
    private function createTable(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                LocaleTableComponent::create()
                    ->setTitle(trans('word.addresses'))
                    ->setVuexNamespace('system/mailDomain/dataTable')
                    ->setHeaderRoute(route('system.mail.domain.address.table.headers', [
                        $this->company->id,
                        $this->mailDomain->system_id,
                        $this->mailDomain->id,
                    ]))
                    ->setItemsRoute(route('system.mail.domain.address.table.items', [
                        $this->company->id,
                        $this->mailDomain->system_id,
                        $this->mailDomain->id,
                    ]))
                    ->setSearchable()
            );
    }
}
