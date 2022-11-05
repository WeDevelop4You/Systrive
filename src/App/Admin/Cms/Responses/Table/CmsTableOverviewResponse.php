<?php

namespace App\Admin\Cms\Responses\Table;

use Domain\Cms\Helpers\CmsTableHelper;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Components\Overviews\Tables\ServerTableComponent;
use Support\Response\Components\Utils\TooltipComponent;
use Support\Response\Response;

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
                'company/cms/table/items/init', 'form'
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
                ->setHeaderButton(
                    MultipleButtonComponent::create()
                        ->setButtons([
                            IconButtonComponent::create()
                                ->setColorOnHover(VuetifyColor::WARNING)
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'company/cms/table/edit',
                                        route('admin.company.cms.table.edit', [
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
                                        route('admin.company.cms.table.destroy', [
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
                ->setVuexNamespace('company/cms/table/items/dataTable')
                ->setHeaderUrl(route('admin.company.cms.table.item.table.headers', [
                    $this->company->id,
                    $this->cms->id,
                    $this->table->id,
                ]))
                ->setItemsUrl(route('admin.company.cms.table.item.table.items', [
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
                                'company/cms/table/items/create',
                                route('admin.company.cms.table.item.create', [
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
                ->setTitle($this->table->label)
                ->setHeaderButton(
                    MultipleButtonComponent::create()
                        ->addButton(
                            IconButtonComponent::create()
                                ->setIcon(
                                    IconComponent::create()->setType(IconType::FAS_HISTORY)
                                )
                                ->setAction(
                                    RequestAction::create()->get(
                                        route('admin.company.cms.table.item.history', [
                                            $this->company->id,
                                            $this->cms->id,
                                            $this->table->id,
                                        ])
                                    )
                                )
                        )
                )
                ->addBody(
                    CmsTableHelper::create($this->table)
                        ->getFormStructure($modal)
                        ->setVuexNamespace('company/cms/table/items/form')
                )
                ->setFooterButton(
                    MultipleButtonComponent::create()
                        ->addClass('gap-3')
                        ->addButton(
                            ButtonComponent::create()
                                ->setColor()
                                ->setTitle(trans('word.save.save'))
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'company/cms/table/items/store',
                                        route('admin.company.cms.table.item.save', [
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
