<?php

namespace App\Company\Cms\DataTables;

use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractTable;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconBtnComponent;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\BadgeComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class CmsTableColumnTable extends AbstractTable
{
    public function __construct(
        private readonly Company $company,
        private readonly Cms $cms,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): array
    {
        return [
            Column::create(trans('word.label.label'), CmsColumnTableMap::COL_LABEL)
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.key.key'), CmsColumnTableMap::COL_KEY)
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.type.type'), CmsColumnTableMap::COL_TYPE)
                ->setSortable()
                ->setSearchable()
                ->setFormat(fn (CmsColumn $data): string => $data->type->trans()),
            Column::create(trans('word.editable'), CmsColumnTableMap::COL_EDITABLE)
                ->setDivider()
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (CmsColumn $data) {
                    $badge = BadgeComponent::create()->setOutlined();

                    return $data->editable
                        ? $badge->setColor(VuetifyColor::SUCCESS)->setValue(trans('word.enabled.enabled'))
                        : $badge->setColor(VuetifyColor::ERROR)->setValue(trans('word.disabled.disabled'));
                }),
            Column::actions()
                ->setFormat(function (CmsColumn $data) {
                    return WrapperComponent::create()
                        ->addComponent(
                            IconBtnComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                                ->setColorOnHover(VuetifyColor::WARNING)
                                ->setAction(
                                    VuexAction::create()->dispatch(
                                        'cms/table/columns/edit',
                                        route('company.cms.table.column.edit', [
                                            $this->company->id,
                                            $this->cms->id,
                                            $data->key,
                                        ])
                                    )
                                )
                        )
                        ->addComponentIf(
                            $data->deletable,
                            IconBtnComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                                ->setColorOnHover(VuetifyColor::ERROR)
                                ->setAction(
                                    RequestAction::create()->get(
                                        route('company.cms.table.column.delete', [
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
