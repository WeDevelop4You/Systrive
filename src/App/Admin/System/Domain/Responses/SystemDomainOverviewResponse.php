<?php

namespace App\Admin\System\Domain\Responses;

use Domain\Company\Models\Company;
use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\ChartType;
use Support\Enums\Component\IconType;
use Support\Enums\System\SystemTemplateType;
use Support\Enums\VestaCommand;
use Support\Response\Actions\VuexAction;
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
                    ->setTitle(trans('word.details'))
                    ->setHeaderButton(
                        MultipleButtonComponent::create()
                            ->addButton(
                                IconButtonComponent::create()
                                    ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'company/system/domain/edit',
                                            route('admin.system.domain.edit', [
                                                $this->company->id,
                                                $this->system->id,
                                                $this->domain->id,
                                            ])
                                        )
                                    )
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
                                    ->setTemplate($data->get('TPL'), SystemTemplateType::WEB),
                                ItemGroupBadgesComponent::create()
                                    ->setLabel(trans('word.aliases.aliases'))
                                    ->convertStringArray($data->get('ALIAS')),
                                ItemBadgeComponent::create()
                                    ->setLabel(trans('word.ssl.ssl'))
                                    ->setVesta($data->get('SSL')),
                            ], 2)
                            ->addDivider()
                            ->addSubheader(trans('word.proxy.proxy'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.template.template'))
                                    ->setTemplate($data->get('PROXY'), SystemTemplateType::DNS),
                                ItemGroupBadgesComponent::create()
                                    ->setLabel(trans('word.extensions.extensions'))
                                    ->convertStringArray($data->get('PROXY_EXT')),
                            ])
                            ->addDivider()
                            ->addSubheader(trans('word.general.general'))
                            ->addItems([
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.create_at'))
                                    ->setValue("{$data->get('DATE')} {$data->get('TIME')}"),
                                ItemBadgeComponent::create()
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
                    ->setTitle(trans('word.disk.disk'))
                    ->addBody(
                        ChartComponent::create()
                            ->setType(ChartType::SYSTEM_USAGES)
                            ->setUrl(route('admin.system.domain.usage', [
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
                    ->setTitle(trans('word.bandwidth.bandwidth'))
                    ->addBody(
                        ChartComponent::create()
                            ->setType(ChartType::SYSTEM_USAGES)
                            ->setUrl(route('admin.system.domain.usage', [
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
