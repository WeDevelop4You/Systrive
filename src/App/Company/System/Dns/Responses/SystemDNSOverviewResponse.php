<?php

namespace App\Company\System\Dns\Responses;

use Domain\Company\Models\Company;
use Domain\System\Models\SystemDNS;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ListComponent;
use Support\Client\Components\Overviews\ListItems\ListItemBadgeComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Components\Overviews\Tables\LocaleTableComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;
use Support\Enums\System\SystemTemplateType;

class SystemDNSOverviewResponse extends AbstractResponse
{
    /**
     * SystemDomainOverviewResponse constructor.
     *
     * @param Company    $company
     * @param SystemDNS  $dns
     * @param Collection $data
     */
    protected function __construct(
        private readonly Company $company,
        private readonly SystemDNS $dns,
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
                        $this->createTable(),
                    ])
            );
    }

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
                            ->addSubheader(trans('word.dns.dns'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.domain.domain'))
                                    ->setValue($this->dns->name),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($this->data->get('TPL'), SystemTemplateType::DNS),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.ttl.ttl'))
                                    ->setValue($this->data->get('TTL')),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.soa.soa'))
                                    ->setValue($this->data->get('SOA')),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.expired.expired'))
                                    ->setValue($this->data->get('EXP')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.general.general'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.serial.number'))
                                    ->setValue($this->data->get('SERIAL')),
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
    private function createTable(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                LocaleTableComponent::create()
                    ->setTitle(trans('word.records'))
                    ->setVuexNamespace('system/dns/dataTable')
                    ->setHeaderRoute(route('system.dns.record.table.headers', [
                        $this->company->id,
                        $this->dns->system_id,
                        $this->dns->id,
                    ]))
                    ->setItemsRoute(route('system.dns.record.table.items', [
                        $this->company->id,
                        $this->dns->system_id,
                        $this->dns->id,
                    ]))
                    ->setSearchable()
            );
    }
}
