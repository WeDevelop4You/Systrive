<?php

namespace App\Company\System\Domain\Responses;

use Domain\Company\Models\Company;
use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
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
use Support\Client\Components\Overviews\ListItems\ListItemGroupBadgesComponent;
use Support\Client\Components\Overviews\ListItems\ListItemURLComponent;
use Support\Client\Response;
use Support\Enums\Component\ChartType;
use Support\Enums\Component\IconType;
use Support\Enums\System\SystemTemplateType;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;

class SystemDomainOverviewResponse extends AbstractResponse
{
    /**
     * SystemDomainOverviewResponse constructor.
     *
     * @param Company      $company
     * @param System       $system
     * @param SystemDomain $domain
     */
    protected function __construct(
        private readonly Company $company,
        private readonly System $system,
        private readonly SystemDomain $domain,
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
            );
    }

    /**
     * @return ColComponent
     */
    private function createCardList(): ColComponent
    {
        $data = Collection::make(
            Vesta::api()->get(
                VestaCommand::GET_USER_DOMAIN,
                $this->system->username,
                $this->domain->name
            )->first()
        );

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
                                            ->setAction(
                                                VuexAction::create()->dispatch(
                                                    'system/domain/edit',
                                                    route('system.domain.edit', [
                                                        $this->company->id,
                                                        $this->system->id,
                                                        $this->domain->id,
                                                    ])
                                                )
                                            )
                                    )
                            )
                    )
                    ->addBody(
                        ListComponent::create()
                            ->addSubheader(trans('word.domain.domain'))
                            ->addItems([
                                ListItemURLComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->domain->name),
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($data->get('TPL'), SystemTemplateType::WEB),
                                ListItemGroupBadgesComponent::create()
                                    ->setLabel(trans('word.aliases.aliases'))
                                    ->convertStringArray($data->get('ALIAS')),
                                ListItemBadgeComponent::create()
                                    ->setLabel(trans('word.ssl.ssl'))
                                    ->setVesta($data->get('SSL')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.proxy.proxy'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($data->get('PROXY'), SystemTemplateType::DNS),
                                ListItemGroupBadgesComponent::create()
                                    ->setLabel(trans('word.extensions.extensions'))
                                    ->convertStringArray($data->get('PROXY_EXT')),
                            ])
                            ->addDivider()
                            ->addSubheader(trans('word.general.general'))
                            ->addItems([
                                ListItemContentComponent::create()
                                    ->setLabel(trans('word.create_at'))
                                    ->setValue("{$data->get('DATE')} {$data->get('TIME')}"),
                                ListItemBadgeComponent::create()
                                    ->setLabel(trans('word.suspended.suspended'))
                                    ->setVesta($data->get('SUSPENDED'), true),
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
                            ->setUrl(route('system.domain.usage', [
                                $this->company->id,
                                $this->system->id,
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
                    ->setHeader(
                        CardHeaderComponent::create()->setTitle(trans('word.bandwidth.bandwidth'))
                    )
                    ->addBody(
                        ChartComponent::create()
                            ->setType(ChartType::SYSTEM_USAGES)
                            ->setUrl(route('system.domain.usage', [
                                $this->company->id,
                                $this->system->id,
                                $this->domain->id,
                                SystemUsageStatisticTypes::BANDWIDTH->value,
                            ]))
                    )
            )
            ->setMdCol(6);
    }
}
