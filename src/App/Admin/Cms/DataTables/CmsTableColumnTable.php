<?php

namespace App\Admin\Cms\DataTables;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
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
use Support\Response\Components\Items\ItemBadgeComponent;

class CmsTableColumnTable extends AbstractTable
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): array
    {
        return [
            Column::create(trans('word.label.label'), CmsColumnTableMap::LABEL)
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.key.key'), CmsColumnTableMap::KEY)
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.type.type'), CmsColumnTableMap::TYPE)
                ->setSortable()
                ->setSearchable()
                ->setFormat(fn (CmsColumn $data): string => $data->type->trans()),
            Column::create(trans('word.editable'), CmsColumnTableMap::EDITABLE)
                ->setDivider()
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (CmsColumn $data) {
                    $badge = ItemBadgeComponent::create()->setOutlined();

                    return $data->editable
                        ? $badge->setColor(VuetifyColor::SUCCESS)->setValue(trans('word.enabled.enabled'))
                        : $badge->setColor(VuetifyColor::ERROR)->setValue(trans('word.disabled.disabled'));
                }),
            Column::actions()
                ->setFormat(function (CmsColumn $data) {
                    return MultipleButtonComponent::create()
                        ->addButtonIf(
                            $data->deletable,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setColorOnHover(VuetifyColor::WARNING)
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'company/cms/table/columns/edit',
                                        route('admin.company.cms.table.column.edit', [
                                            $this->company->id,
                                            $this->cms->id,
                                            $data->key,
                                        ])
                                    )
                                )
                        )
                        ->addButtonIf(
                            $data->deletable,
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                ->setColorOnHover(VuetifyColor::ERROR)
                                ->setAction(
                                    RequestAction::create()->get(
                                        route('admin.company.cms.table.column.delete', [
                                            $this->company->id,
                                            $this->cms->id,
                                            $data->key,
                                        ])
                                    )
                                )
                        );
                }),
        ];
    }
}
