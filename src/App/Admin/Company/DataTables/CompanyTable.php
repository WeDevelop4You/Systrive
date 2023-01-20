<?php

namespace App\Admin\Company\DataTables;

use Carbon\CarbonInterface;
use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Mappings\CompanyTableMap;
use Domain\Company\Mappings\CompanyUserTableMap;
use Domain\Company\Models\Company;
use Domain\User\Mappings\UserTableMap;
use Domain\User\Models\UserProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Support\Abstracts\AbstractTable;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\IconButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\BadgeComponent;
use Support\Client\Components\Misc\Icons\IconComponent;
use Support\Client\Components\Utils\TooltipComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
use Support\Helpers\ApplicationHelper;

class CompanyTable extends AbstractTable
{
    /**
     * {@inheritDoc}
     */
    public function handle(): array
    {
        return [
            Column::id(),
            Column::create(trans('word.name.name'), 'name')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.email.email'), 'email')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.full_name'), 'full_name', 'owner.full_name')
                ->setSortable(function (Builder $query, string $direction) {
                    $query->orderBy(UserProfile::orWhereHas('user', function (Builder $query) {
                        $query->whereHas(CompanyTableMap::RELATION_COMPANY_USER, function (Builder $query) {
                            $query->where(CompanyUserTableMap::COL_IS_OWNER, true)
                                ->whereColumn(CompanyUserTableMap::COL_COMPANY_ID, CompanyTableMap::COL_ID);
                        })->withTrashed();
                    })->selectRaw("CONCAT_WS(' ', first_name, middle_name, last_name)"), $direction);
                })
                ->setSearchable(function (Builder $query, string $search) {
                    $query->orWhereHas(CompanyTableMap::RELATION_USERS, function (Builder $query) use ($search) {
                        $query->where(CompanyUserTableMap::COL_IS_OWNER, true)
                            ->whereHas(UserTableMap::RELATION_PROFILE, function (Builder $query) use ($search) {
                                $query->where(DB::raw("CONCAT_WS(' ', first_name, middle_name, last_name)"), 'like', "%{$search}%");
                            })->withTrashed();
                    });
                }),
            Column::create(trans('word.status.status'), 'status')
                ->setSortable()
                ->setSearchable(CompanyStatusTypes::class)
                ->setAlignment(VuetifyTableAlignmentType::CENTER)
                ->setFormat(function (Company $data) {
                    if (\is_null($data->deleted_at)) {
                        return BadgeComponent::create()
                            ->setValue($data->status->getTranslation())
                            ->setColor($data->status->getColor())
                            ->setOutlined();
                    }

                    return null;
                }),
            Column::create(trans('word.created_at'), 'created_at')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (Company $data, string $key) {
                    return $data->getAttribute($key)->toDatetimeString();
                }),
            Column::create(trans('word.deleted_in'), 'deleted_at')
                ->setSortable()
                ->setDivider()
                ->setSearchable()
                ->setFormat(function (Company $data, string $key) {
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
                ->setFormat(function (Company $data) {
                    return $this->createActions($data);
                }),
        ];
    }

    /**
     * @param Company $data
     *
     * @return MultipleButtonComponent
     */
    private function createActions(Company $data): MultipleButtonComponent
    {
        $isNotDeleted = \is_null($data->deleted_at);

        return MultipleButtonComponent::create()
            ->addButtonIf(
                $data->status === CompanyStatusTypes::EXPIRED && $isNotDeleted,
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_PAPER_PLANE))
                    ->setColorOnHover(VuetifyColor::PRIMARY)
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setText(trans('word.resend.invite'))
                            ->setTop()
                    )
                    ->setAction(
                        RequestAction::create()
                            ->post(
                                route('admin.company.invite.resend', [
                                    $data->id,
                                ])
                            )
                            ->setOnSuccessAction(
                                VuexAction::create()->refreshTable('companies')
                            )
                    ),
            )
            ->addButton(
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_EYE))
                    ->setColorOnHover(VuetifyColor::INFO)
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setText(trans('word.show.show'))
                            ->setTop()
                    )
                    ->setAction(
                        VuexAction::create()
                            ->dispatch(
                                'companies/show',
                                route('admin.company.show', [
                                    $data->id,
                                ])
                            )
                    ),
            )
            ->addButton(
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_PEN))
                    ->setColorOnHover(VuetifyColor::WARNING)
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setText(trans('word.edit.edit'))
                            ->setTop()
                    )
                    ->setAction(
                        VuexAction::create()->dispatch(
                            'companies/edit',
                            route('admin.company.edit', [
                                $data->id,
                            ])
                        )
                    ),
            )
            ->addButton(
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::ACCENT)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_EXTERNAL_LINK_ALT))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.view.view'))
                    )
                    ->setHref(ApplicationHelper::getCompanyRoute($data))
            )
            ->addButtonIf(
                ! $isNotDeleted,
                IconButtonComponent::create()
                    ->setColorOnHover(VuetifyColor::ACCENT)
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_UNDO_ALT))
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setTop()
                            ->setText(trans('word.restore.restore'))
                    )
                    ->setAction(
                        RequestAction::create()
                            ->put(route('admin.company.restore', [
                                $data->id,
                            ]))->setOnSuccessAction(
                                VuexAction::create()->refreshTable('companies/dataTable')
                            )
                    )
            )
            ->addButton(
                IconButtonComponent::create()
                    ->setIcon(IconComponent::create()->setType(IconType::FAS_TRASH))
                    ->setColorOnHover(VuetifyColor::ERROR)
                    ->setTooltip(
                        TooltipComponent::create()
                            ->setText(trans('word.delete.delete'))
                            ->setTop()
                    )
                    ->setAction(
                        RequestAction::create()
                            ->get(route('admin.company.destroy', [
                                $data->id,
                            ]))
                    ),
            );
    }
}
