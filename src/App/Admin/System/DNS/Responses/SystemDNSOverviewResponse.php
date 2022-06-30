<?php

namespace App\Admin\System\DNS\Responses;

use App\Admin\System\DNS\Resources\SystemDNSResource;
use Domain\Company\Models\Company;
use Domain\System\Models\SystemDNS;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Enums\IconTypes;
use Support\Enums\System\SystemTemplateTypes;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemBadgeComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\ListComponent;
use Support\Response\Components\Overviews\Tables\LocaleTableComponent;
use Support\Response\Response;

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
     * @inheritDoc
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
            )
            ->addData(SystemDNSResource::make($this->dns));
    }

    private function createCardList(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.details'))
                    ->setHeaderButton(
                        MultipleButtonComponent::create()
                            ->addButton(
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconTypes::FAS_PEN))
                            )
                    )
                    ->addBody(
                        ListComponent::create()
                            ->addSubheader(trans('word.dns.dns'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.domain.domain'))
                                    ->setValue($this->dns->name),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($this->data->get('TPL'), SystemTemplateTypes::DNS),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.ttl.ttl'))
                                    ->setValue($this->data->get('TTL')),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.soa.soa'))
                                    ->setValue($this->data->get('SOA')),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.expired.expired'))
                                    ->setValue($this->data->get('EXP')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.general.general'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.serial.number'))
                                    ->setValue($this->data->get('SERIAL')),
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
    private function createTable(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                LocaleTableComponent::create()
                    ->setTitle(trans('word.records'))
                    ->setVuexNamespace('company/system/dns')
                    ->setHeaderUrl(route('admin.system.dns.record.table.headers', [
                        $this->company->id,
                        $this->dns->system_id,
                        $this->dns->id,
                    ]))
                    ->setItemsUrl(route('admin.system.dns.record.table.items', [
                        $this->company->id,
                        $this->dns->system_id,
                        $this->dns->id,
                    ]))
                    ->setSearchable()
            );
    }
}
