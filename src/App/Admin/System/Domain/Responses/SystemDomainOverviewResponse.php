<?php

namespace App\Admin\System\Domain\Responses;

use App\Admin\System\Domain\Resources\SystemDomainShowResource;
use Domain\Company\Models\Company;
use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Models\SystemDomain;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Enums\ChartTypes;
use Support\Enums\IconTypes;
use Support\Enums\System\SystemTemplateTypes;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemBadgeComponent;
use Support\Response\Components\Items\ItemGroupBadgesComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Items\ItemURLComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\ChartComponent;
use Support\Response\Components\Overviews\ListComponent;
use Support\Response\Response;

class SystemDomainOverviewResponse extends AbstractResponse
{
    /**
     * SystemDomainOverviewResponse constructor.
     *
     * @param Company      $company
     * @param SystemDomain $domain
     * @param Collection   $data
     */
    protected function __construct(
        private readonly Company $company,
        private readonly SystemDomain $domain,
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
                        $this->createCardBandwidthUsages(),
                    ])
            )
            ->addData(new SystemDomainShowResource($this->domain));
    }

    /**
     * @return ColComponent
     */
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
                            ->addSubheader(trans('word.domain.domain'))
                            ->addItems([
                                ItemURLComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->domain->name),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($this->data->get('TPL'), SystemTemplateTypes::WEB),
                                ItemGroupBadgesComponent::create()
                                    ->setLabel(trans('word.aliases.aliases'))
                                    ->convertStringArray($this->data->get('ALIAS')),
                                ItemBadgeComponent::create()
                                    ->setLabel(trans('word.ssl.ssl'))
                                    ->setVesta($this->data->get('SSL')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.proxy.proxy'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($this->data->get('PROXY'), SystemTemplateTypes::DNS),
                                ItemGroupBadgesComponent::create()
                                    ->setLabel(trans('word.extensions.extensions'))
                                    ->convertStringArray($this->data->get('PROXY_EXT')),
                            ])
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
                            ->setType(ChartTypes::SYSTEM_USAGES)
                            ->setUrl(route('admin.system.domain.usage', [
                                $this->company->id,
                                $this->domain->system_id,
                                $this->domain->id,
                                SystemUsageStatisticTypes::DISK->value,
                            ]))
                    )
            )
            ->setMdCol(6);
    }

    /**
     * @return ColComponent
     */
    private function createCardBandwidthUsages(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.bandwidth.bandwidth'))
                    ->addBody(
                        ChartComponent::create()
                            ->setType(ChartTypes::SYSTEM_USAGES)
                            ->setUrl(route('admin.system.domain.usage', [
                                $this->company->id,
                                $this->domain->system_id,
                                $this->domain->id,
                                SystemUsageStatisticTypes::BANDWIDTH->value,
                            ]))
                    )
            )
            ->setMdCol(6);
    }
}
