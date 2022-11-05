<?php

namespace App\Admin\Cms\DataTables;

use Carbon\CarbonInterface;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Support\Carbon;
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

class CmsTable extends AbstractTable
{
    public function __construct(
        private readonly Company $company,
    ) {
        //
    }

    /**
     * @inheritDoc
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
                    return $data->username->decryptString();
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

                    $deletedDate = Carbon::now()->startOfDay()->addDays(31);

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
     * @return MultipleButtonComponent
     */
    private function createActions(Cms $data): MultipleButtonComponent
    {
        return MultipleButtonComponent::create()
            ->addButtonIf(
                \is_null($data->deleted_at),
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::ERROR)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.delete.delete'))
                    )
                    ->setAction(
                        RequestAction::create()
                            ->get(route('admin.sa.company.cms.destroy', [
                                $this->company->id,
                                $data->id,
                            ]))
                    ),
            )
            ->addButtonIf(
                !\is_null($data->deleted_at),
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::ACCENT)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH_RESTORE))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.restore.restore'))
                    )
                    ->setAction(
                        RequestAction::create()
                            ->put(route('admin.sa.company.cms.restore', [
                                $this->company->id,
                                $data->id,
                            ]))->setOnSuccessAction(
                                VuexAction::create()->refreshTable('company/cms/dataTable')
                            )
                    ),
            );
    }
}
