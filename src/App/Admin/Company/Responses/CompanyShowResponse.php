<?php

namespace App\Admin\Company\Responses;

use App\Company\Dashboard\Resources\CompanyResource;
use App\Company\Role\Responses\RoleOverviewResponse;
use App\Company\User\Responses\UserOverviewResponse;
use Domain\Company\Enums\CompanyModuleTypes;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ListComponent;
use Support\Client\Components\Overviews\ListItems\ListItemBadgeComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Components\Overviews\ListItems\ListItemURLComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Components\Popups\Modals\ShowModal;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyColor;

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
     * {@inheritDoc}
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
            ->setHeader(
                CardHeaderComponent::create()
                    ->setTitle(trans('word.details'))
            )
            ->addBody(
                ListComponent::create()
                    ->addItems([
                        ListItemContentComponent::create()
                            ->setLabel(trans('word.id'))
                            ->setValue($this->company->id),
                        ListItemContentComponent::create()
                            ->setLabel(trans('word.name.name'))
                            ->setValue($this->company->name),
                        ListItemContentComponent::create()
                            ->setLabel(trans('word.email.email'))
                            ->setValue($this->company->email),
                        ListItemURLComponent::create()
                            ->setLabel(trans('word.domain.domain'))
                            ->setValue($this->company->domain),
                    ])
                    ->addDivider()
                    ->addItems([
                        ListItemContentComponent::create()
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

            return ListItemBadgeComponent::create()
                ->setLabel(CompanyModuleTypes::from($module)->trans())
                ->setValue($value)
                ->setColor($color)
                ->setOutlined();
        })->toArray();

        return CardComponent::create()
            ->setHeader(
                CardHeaderComponent::create()
                    ->setTitle(trans('word.modules'))
            )
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
                        ColComponent::create()->setComponent(UserOverviewResponse::table($this->company)),
                        ColComponent::create()->setComponent(RoleOverviewResponse::table($this->company)),
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
            ->setHeaderRoute(route('admin.company.cms.table.headers', [
                $this->company->id,
            ]))
            ->setItemsRoute(route('admin.company.cms.table.items', [
                $this->company->id,
            ]))
            ->setPrependComponent(
                ButtonComponent::create()
                    ->setSize()
                    ->setColor()
                    ->setTitle(trans('word.create.create'))
                    ->setAction(VuexAction::create()->dispatch(
                        'company/cms/create',
                        route('admin.company.cms.create', $this->company->id)
                    ))
            );
    }
}
