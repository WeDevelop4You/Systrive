<?php

namespace App\Admin\Company\Responses;

use App\Admin\Company\Resources\CompanyResource;
use App\Admin\Company\Role\Responses\CompanyRoleOverviewResponse;
use App\Admin\Company\User\Responses\CompanyUserOverviewResponse;
use Domain\Company\Enums\CompanyModuleTypes;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Items\ItemBadgeComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Items\ItemURLComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\ListComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Components\Popups\Modals\ShowModal;
use Support\Response\Response;

class CompanyShowResponse extends AbstractResponse
{
    /**
     * CompanyCreateResponse constructor.
     *
     * @param Company $company
     */
    protected function __construct(
        private readonly Company $company,
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(CompanyResource::make($this->company))
            ->addPopup(
                ShowModal::create('companies')
                    ->setFullscreen()
                    ->setTitle($this->company->name)
                    ->addComponent(
                        RowComponent::create()
                            ->setCols([
                                $this->createLists(),
                                $this->createTables(),
                            ])
                    )
            );
    }

    /**
     * @return ColComponent
     */
    private function createLists(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(3)
            ->setComponent(
                RowComponent::create()
                    ->setCols([
                        ColComponent::create()->setComponent($this->createInfoList()),
                        ColComponent::create()->setComponent($this->createModuleList()),
                    ])
            );
    }

    /**
     * @return CardComponent
     */
    private function createInfoList(): CardComponent
    {
        return CardComponent::create()
            ->setTitle(trans('word.details'))
            ->addBody(
                ListComponent::create()
                    ->addItems([
                        ItemTextComponent::create()
                            ->setLabel(trans('word.id'))
                            ->setValue($this->company->id),
                        ItemTextComponent::create()
                            ->setLabel(trans('word.name.name'))
                            ->setValue($this->company->name),
                        ItemTextComponent::create()
                            ->setLabel(trans('word.email.email'))
                            ->setValue($this->company->email),
                        ItemURLComponent::create()
                            ->setLabel(trans('word.domain.domain'))
                            ->setValue($this->company->domain),
                    ])
                    ->addDivider()
                    ->addItems([
                        ItemTextComponent::create()
                            ->setCondition($this->company->hasSystemModule(true))
                            ->setLabel(trans('word.system.system'))
                            ->setValue($this->company->system?->username),
                    ])
            )
            ->addAdditionalBodyClass('pa-0');
    }

    /**
     * @return CardComponent
     */
    private function createModuleList(): CardComponent
    {
        $modules = $this->company->modules->map(function (bool $condition, string $module) {
            if ($condition) {
                $color = VuetifyColor::SUCCESS;
                $value = trans('word.enabled.enabled');
            } else {
                $color = VuetifyColor::ERROR;
                $value = trans('word.disabled.disabled');
            }

            return ItemBadgeComponent::create()
                ->setLabel(CompanyModuleTypes::from($module)->trans())
                ->setValue($value)
                ->setColor($color)
                ->setOutlined();
        })->toArray();

        return CardComponent::create()
            ->setTitle(trans('word.modules'))
            ->addBody(
                ListComponent::create()->addItems($modules)
            )
            ->addAdditionalBodyClass('pa-0');
    }

    /**
     * @return ColComponent
     */
    private function createTables(): ColComponent
    {
        return ColComponent::create()
            ->setDefaultCol(9)
            ->setComponent(
                RowComponent::create()
                    ->setCols([
                        ColComponent::create()->setComponent(CompanyUserOverviewResponse::table($this->company)),
                        ColComponent::create()->setComponent(CompanyRoleOverviewResponse::table($this->company)),
                    ])
                    ->addColIf(
                        $this->company->hasCMSModule(true) || $this->company->cms()->count(),
                        ColComponent::create()->setComponent($this->createCMSDatabaseTable()),
                    )
            );
    }

    /**
     * @return ServerTableComponent
     */
    private function createCMSDatabaseTable(): ServerTableComponent
    {
        return ServerTableComponent::create()
            ->setSearchable()
            ->setTitle(trans('word.cms.databases'))
            ->setVuexNamespace('company/cms/dataTable')
            ->setHeaderUrl(route('admin.sa.company.cms.table.headers', [
                $this->company->id,
            ]))
            ->setItemsUrl(route('admin.sa.company.cms.table.items', [
                $this->company->id,
            ]))
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setSize()
                    ->setColor()
                    ->setTitle(trans('word.create.create'))
                    ->setAction(VuexAction::create()->dispatch(
                        'company/cms/create',
                        route('admin.sa.company.cms.create', $this->company->id)
                    ))
            );
    }
}
