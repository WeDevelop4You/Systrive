<?php

namespace App\Admin\Cms\DataTables;

use Carbon\CarbonInterface;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Support\Carbon;
use Support\Abstracts\AbstractTable;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconBtnComponent;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\IconComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;

class CmsTable extends AbstractTable
{
    public function __construct(
        private readonly Company $company,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): array
    {
        return [
            Column::id(),
            Column::create(trans('word.name.name'), 'name')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.database.name'), 'database')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.username'), 'username')
                ->setFormat(function (Cms $data) {
                    return $data->username->decrypt;
                }),
            Column::create(trans('word.created_at'), 'created_at')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (Cms $data, string $key) {
                    return $data->getAttribute($key)->toDatetimeString();
                }),
            Column::create(trans('word.deleted_in'), 'deleted_at')
                ->setSortable()
                ->setDivider()
                ->setSearchable()
                ->setFormat(function (Cms $data, string $key) {
                    /** @var Carbon|null $date */
                    $date = $data->getAttribute($key);

                    if (\is_null($date)) {
                        return null;
                    }

                    $deletedDate = $date->startOfDay()->addDays(31);

                    return $deletedDate->diffForHumans(Carbon::now()->startOfDay(), [
                        'syntax' => CarbonInterface::DIFF_ABSOLUTE,
                        'skip' => ['m', 'w'],
                        'minimumUnit' => 'd',
                    ]);
                }),
            Column::actions()
                ->setFormat(function (Cms $data) {
                    return $this->createActions($data);
                }),
        ];
    }

    /**
     * @param Cms $data
     *
     * @return WrapperComponent
     */
    private function createActions(Cms $data): WrapperComponent
    {
        return WrapperComponent::create()
            ->addComponentIf(
                \is_null($data->deleted_at),
                IconBtnComponent::create()
                    ->setColorOnHover(VuetifyColor::ERROR)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.delete.delete'))
                    )
                    ->setAction(
                        RequestAction::create()
                            ->get(route('admin.company.cms.destroy', [
                                $this->company->id,
                                $data->id,
                            ]))
                    ),
            )
            ->addComponentIf(
                !\is_null($data->deleted_at),
                IconBtnComponent::create()
                    ->setColorOnHover(VuetifyColor::ACCENT)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_UNDO_ALT))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.restore.restore'))
                    )
                    ->setAction(
                        RequestAction::create()
                            ->put(route('admin.company.cms.restore', [
                                $this->company->id,
                                $data->id,
                            ]))->setOnSuccessAction(
                                VuexAction::create()->refreshTable('cms/dataTable')
                            )
                    ),
            );
    }
}
