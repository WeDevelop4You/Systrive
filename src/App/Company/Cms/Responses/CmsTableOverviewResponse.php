<?php

namespace App\Company\Cms\Responses;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Buttons\DropdownBtnComponent;
use Support\Client\Components\Buttons\IconBtnComponent;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Menu\Items\MenuItemComponent;
use Support\Client\Components\Menu\MenuComponent;
use Support\Client\Components\Menu\Types\GroupMenuTypeComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTransitionType;

class CmsTableOverviewResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
        private readonly CmsTable $table,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $response = Response::create()->addComponent(
            RowComponent::create()->setCols([
                $this->createTopBar(),
                $this->isTable() ? $this->createTable() : $this->createForm(),
            ])
        );

        if (!$this->isTable()) {
            $response->addAction(VuexAction::create()->dispatch(
                'cms/table/items/init',
                'form'
            ));
        }

        return $response;
    }

    /**
     * @return ColComponent
     */
    private function createTopBar(): ColComponent
    {
        return ColComponent::create()->setComponent(
            CardComponent::create()
                ->setHeader(
                    CardHeaderComponent::create()
                        ->setTitle($this->table->label)
                        ->setButton(
                            WrapperComponent::create()
                                ->addComponentIf(
                                    !$this->isTable(),
                                    IconBtnComponent::create()
                                        ->setIcon(
                                            IconComponent::create()->setType(IconType::FAS_HISTORY)
                                        )
                                        ->setAction(
                                            RequestAction::create()->get(
                                                route('company.cms.table.item.history', [
                                                    $this->company->id,
                                                    $this->cms->id,
                                                    $this->table->id,
                                                ])
                                            )
                                        )
                                )
                                ->addComponentIf(
                                    Auth::user()->isSuperAdmin(),
                                    DropdownBtnComponent::create()
                                        ->setBottom()
                                        ->setOffsetY()
                                        ->setTransition(VuetifyTransitionType::SLIDE_Y)
                                        ->setButton(
                                            IconBtnComponent::create()
                                                ->setIcon(IconComponent::create()->setType(IconType::FAS_COG))
                                                ->setTooltip(
                                                    TooltipComponent::create()
                                                        ->setTop()
                                                        ->setText(trans('word.settings.settings'))
                                                )
                                        )
                                        ->setMenu($this->createMenu())
                                )
                                ->addComponentIf(
                                    Auth::user()->isSuperAdmin(),
                                    IconBtnComponent::create()
                                        ->setColorOnHover(VuetifyColor::ERROR)
                                        ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                        ->setAction(
                                            RequestAction::create()->get(
                                                route('company.cms.table.destroy', [
                                                    $this->company->id,
                                                    $this->cms->id,
                                                    $this->table->id,
                                                ])
                                            )
                                        )
                                        ->setTooltip(
                                            TooltipComponent::create()
                                                ->setTop()
                                                ->setText(trans('word.delete.delete'))
                                        )
                                )
                        )
                )
        );
    }

    /**
     * @return MenuComponent
     */
    private function createMenu(): MenuComponent
    {
        return MenuComponent::create()
            ->setNav()
            ->addType(
                GroupMenuTypeComponent::create()
                    ->addItems([
                        MenuItemComponent::create()
                            ->setTitle(trans('word.table.table'))
                            ->setPrepend(IconComponent::create()->setType(IconType::FAS_PEN))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'cms/table/edit',
                                    route('company.cms.table.edit', [
                                        $this->company->id,
                                        $this->cms->id,
                                        $this->table->id,
                                    ])
                                )
                            ),
                        MenuItemComponent::create()
                            ->setTitle(trans('word.api.api'))
                            ->setPrepend(IconComponent::create()->setType(IconType::FAS_CLOUD))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'cms/table/api/edit',
                                    route('company.cms.table.api', [
                                        $this->company->id,
                                        $this->cms->id,
                                        $this->table->id,
                                    ])
                                )
                            ),
                    ])
            );
    }

    /**
     * @return ColComponent
     */
    private function createTable(): ColComponent
    {
        return ColComponent::create()->setComponent(
            ServerTableComponent::create()
                ->setSearchable()
                ->setVuexNamespace('cms/table/items/dataTable')
                ->setHeaderRoute(route('company.cms.table.item.table.headers', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                    'default',
                ]))
                ->setItemsRoute(route('company.cms.table.item.table.items', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                    'default',
                ]))
                ->setPrependComponent(
                    BtnComponentType::create()
                        ->setColor()
                        ->setTitle('word.create.create')
                        ->setAction(
                            VuexAction::create()->dispatch(
                                'cms/table/items/create',
                                route('company.cms.table.item.create', [
                                    $this->company->id,
                                    $this->cms->id,
                                    $this->table->id,
                                ])
                            )
                        )
                )
        );
    }

    private function createForm(): ColComponent
    {
        $modal = CmsModel::latest()->firstOrNew();

        return ColComponent::create()->setComponent(
            CardComponent::create()
                ->addBody(
                    FormComponent::create()
                        ->setVuexNamespace('cms/table/items/form')
                        ->setItems(
                            $this->table->formColumns->createFormStructure($modal)->toArray()
                        )
                )
                ->setFooter(
                    WrapperComponent::create()
                        ->setClass('gap-3')
                        ->addComponent(
                            BtnComponentType::create()
                                ->setColor()
                                ->setTitle(trans('word.save.save'))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'cms/table/items/store',
                                        route('company.cms.table.item.save', [
                                            $this->company->id,
                                            $this->cms->id,
                                            $this->table->id,
                                        ])
                                    )
                                )
                        )
                )
                ->addAdditionalBodyClass('px-4')
        );
    }

    private function isTable(): bool
    {
        return $this->table->is_table;
    }
}
