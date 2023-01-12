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
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\Tables\ServerTableComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\Response;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;

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
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $response = Response::create();

        if ($this->table->is_table) {
            $content = $this->createTable();
        } else {
            $content = $this->createForm();

            $response->addAction(VuexAction::create()->dispatch(
                'cms/table/items/init',
                'form'
            ));
        }

        return $response->addComponent(
            RowComponent::create()
                ->addColIf(
                    Auth::user()->isSuperAdmin(),
                    $this->createTopBar()
                )
                ->addCol($content)
        );
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
                        ->setButton(
                            MultipleButtonComponent::create()
                                ->setButtons([
                                    IconButtonComponent::create()
                                        ->setColorOnHover(VuetifyColor::WARNING)
                                        ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                        ->setAction(
                                            VuexAction::create()->dispatch(
                                                'cms/table/edit',
                                                route('company.cms.table.edit', [
                                                    $this->company->id,
                                                    $this->cms->id,
                                                    $this->table->id,
                                                ])
                                            )
                                        )
                                        ->setTooltip(
                                            TooltipComponent::create()
                                                ->setTop()
                                                ->setText(trans('word.edit.edit'))
                                        ),
                                    IconButtonComponent::create()
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
                                        ),
                                ])
                        )
                )
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
                ->setTitle($this->table->label)
                ->setVuexNamespace('cms/table/items/dataTable')
                ->setHeaderRoute(route('company.cms.table.item.table.headers', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                ]))
                ->setItemsRoute(route('company.cms.table.item.table.items', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                ]))
                ->setPrependComponent(
                    ButtonComponent::create()
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
        $modal = CmsModel::latest()->firstOrNew()->replicate();

        return ColComponent::create()->setComponent(
            CardComponent::create()
                ->setHeader(
                    CardHeaderComponent::create()
                        ->setTitle($this->table->label)
                        ->setButton(
                            MultipleButtonComponent::create()
                                ->addButton(
                                    IconButtonComponent::create()
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
                        )
                )
                ->addBody(
                    FormComponent::create()
                        ->setVuexNamespace('cms/table/items/form')
                        ->setItems(
                            $this->table->formColumns->createFormStructure($modal)->toArray()
                        )
                )
                ->setFooter(
                    MultipleButtonComponent::create()
                        ->setClass('gap-3')
                        ->addButton(
                            ButtonComponent::create()
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
}
