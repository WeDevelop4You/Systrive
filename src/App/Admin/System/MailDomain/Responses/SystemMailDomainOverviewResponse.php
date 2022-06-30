<?php

namespace App\Admin\System\MailDomain\Responses;

use App\Admin\System\MailDomain\Resources\SystemMailDomainResource;
use Domain\Company\Models\Company;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractResponse;
use Support\Enums\ChartTypes;
use Support\Enums\IconTypes;
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
use Support\Response\Components\Overviews\Tables\LocaleTableComponent;
use Support\Response\Response;

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
     * @inheritDoc
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
            )
            ->addData(new SystemMailDomainResource($this->mailDomain));
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
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.name.name'))
                                    ->setValue($this->mailDomain->name),
                                ItemTextComponent::create()
                                    ->setLabel(trans('word.catch.all'))
                                    ->setValue($this->data->get('CATCHALL')),
                                ItemBadgeComponent::create()
                                    ->setLabel(trans('word.anti.virus'))
                                    ->setVesta($this->data->get('ANTIVIRUS')),
                                ItemBadgeComponent::create()
                                    ->setLabel(trans('word.anti.spam'))
                                    ->setVesta($this->data->get('ANTISPAM')),
                                ItemBadgeComponent::create()
                                    ->setLabel(trans('word.dkim.dkim'))
                                    ->setVesta($this->data->get('DKIM')),
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
                            ->setType(ChartTypes::SYSTEM_USAGES)
                            ->setUrl(route('admin.system.mail.domain.usage', [
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
                    ->setVuexNamespace('company/system/mailDomain')
                    ->setHeaderUrl(route('admin.system.mail.domain.address.table.headers', [
                        $this->company->id,
                        $this->mailDomain->system_id,
                        $this->mailDomain->id,
                    ]))
                    ->setItemsUrl(route('admin.system.mail.domain.address.table.items', [
                        $this->company->id,
                        $this->mailDomain->system_id,
                        $this->mailDomain->id,
                    ]))
                    ->setSearchable()
            );
    }
}
