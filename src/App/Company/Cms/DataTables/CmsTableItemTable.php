<?php

namespace App\Company\Cms\DataTables;

use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractTable;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class CmsTableItemTable extends AbstractTable
{
    /**
     * CmsTableItemTable constructor.
     *
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     */
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
    protected function handle(): array
    {
        return $this->table->tableColumns->createTableStructure()->add(
            Column::actions()->setFormat(function (CmsModel $data) {
                return $this->table->is_table
                    ? $this->createEditActions($data)
                    : $this->createViewAction($data);
            })
        )->toArray();
    }

    /**
     * @param CmsModel $data
     *
     * @return MultipleButtonComponent
     */
    private function createEditActions(CmsModel $data): MultipleButtonComponent
    {
        return MultipleButtonComponent::create()
            ->setButtons([
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::WARNING)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.edit.edit'))
                    )
                    ->setAction(
                        VuexAction::create()->dispatch(
                            'cms/table/items/edit',
                            route('company.cms.table.item.edit', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                $data->id,
                            ])
                        )
                    ),
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::ERROR)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.delete.delete'))
                    )
                    ->setAction(
                        RequestAction::create()->get(
                            route('company.cms.table.item.delete', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                $data->id,
                            ])
                        )
                    ),
            ]);
    }

    private function createViewAction(CmsModel $data): MultipleButtonComponent
    {
        return MultipleButtonComponent::create()
            ->addButton(
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::INFO)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_EYE))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.show.show'))
                    )
                    ->setAction(
                        RequestAction::create()->get(
                            route('company.cms.table.item.history.restore', [
                                $this->company->id,
                                $this->cms->id,
                                $this->table->id,
                                $data->id,
                            ])
                        )
                    )
            );
    }
}
