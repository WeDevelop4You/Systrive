<?php

namespace App\Admin\Cms\DataTables;

use Domain\Cms\Helpers\CmsTableHelper;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractTable;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Utils\TooltipComponent;

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
     * @inheritDoc
     */
    protected function handle(): array
    {
        return CmsTableHelper::create($this->table)
            ->getColumnStructure(
                Column::actions()->setFormat(function (CmsModel $data) {
                    return $this->table->is_table
                        ? $this->createEditActions($data)
                        : $this->createViewAction($data);
                })
            );
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
                            'company/cms/table/items/edit',
                            route('admin.company.cms.table.item.edit', [
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
                            route('admin.company.cms.table.item.delete', [
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
                            route('admin.company.cms.table.item.history.restore', [
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
