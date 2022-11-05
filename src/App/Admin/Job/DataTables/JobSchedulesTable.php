<?php

namespace App\Admin\Job\DataTables;

use Domain\Job\Enums\JobOperationStatusTypes;
use Domain\Job\Mappings\JobOperationTableMap;
use Domain\Job\Models\JobOperation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractTable;
use Support\Enums\Component\IconType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
use Support\Enums\ScheduleType;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Buttons\IconButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Icons\IconComponent;
use Support\Response\Components\Items\ItemBadgeComponent;
use Support\Response\Components\Utils\TooltipComponent;

class JobSchedulesTable extends AbstractTable
{
    /**
     * @inheritDoc
     */
    protected function handle(): array
    {
        return [
            Column::index(),
            Column::create(trans('word.name'), 'schedule_type')
                ->setSortable()
                ->setSearchable(ScheduleType::class)
                ->setFormat(function (JobOperation $data) {
                    return $data->schedule_type?->getTranslation();
                }),
            Column::create(trans('word.started_at'), 'start_time')
                ->setSortable()
                ->setFormat(function (JobOperation $data) {
                    if (\is_null($data->start_time)) {
                        return trans('word.not.started');
                    }

                    return Carbon::createFromTimestampMs($data->start_time)->toDateTimeString();
                }),
            Column::create(trans('word.duration'), 'duration')
                ->setSortable(function (Builder $query, string $direction) {
                    return $query->orderBy(DB::raw("`end_time` - `start_time`"), $direction);
                })
                ->setSearchable(function (Builder $query, string $search) {
                    return $query->orWhere(DB::raw("`end_time` - `start_time`"), 'like', "%{$search}%");
                })
                ->setAlignment(VuetifyTableAlignmentType::CENTER)
                ->setFormat(function (JobOperation $data) {
                    if (\is_null($data->start_time) || \is_null($data->end_time)) {
                        return ItemBadgeComponent::create()
                            ->setValue(trans('word.no.duration'))
                            ->setColor(VuetifyColor::LIGHT_GRAY)
                            ->setOutlined();
                    }

                    return $this->createDuration($data);
                }),
            Column::create(trans('word.status'), 'status')
                ->setSortable()
                ->setAlignment(VuetifyTableAlignmentType::CENTER)
                ->setSearchable(JobOperationStatusTypes::class)
                ->setFormat(function (JobOperation $data) {
                    return ItemBadgeComponent::create()
                        ->setValue($data->status->getTranslation())
                        ->setColor($data->status->getColor())
                        ->setOutlined();
                }),
            Column::create(trans('word.processes'), 'children_count')
                ->setAlignment(VuetifyTableAlignmentType::CENTER),
            Column::create(trans('word.created_at'), 'created_at')
                ->setDivider()
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (JobOperation $data, string $key) {
                    return $data->getAttribute($key)->toDatetimeString();
                }),
            Column::actions()
                ->setFormat(function (JobOperation $data) {
                    return MultipleButtonComponent::create()
                        ->addButton(
                            IconButtonComponent::create()
                                ->setIcon(IconComponent::create()->setType(IconType::FAS_EYE))
                                ->setTooltip(
                                    TooltipComponent::create()
                                        ->setTop()
                                        ->setText(trans('word.processes'))
                                )
                                ->setAction(
                                    RequestAction::create()->get(
                                        route('admin.admin.job.schedule.process.show', [
                                            $data->id,
                                        ])
                                    )
                                )
                        );
                }),
        ];
    }

    /**
     * @param JobOperation $data
     *
     * @return ItemBadgeComponent
     */
    private function createDuration(JobOperation $data): ItemBadgeComponent
    {
        $duration = $data->end_time - $data->start_time;
        $maxDurationTimeGood = JobOperationTableMap::DURATION_TIME_GOOD * $data->children_count;
        $maxDurationTimeMedium = JobOperationTableMap::DURATION_TIME_MEDIUM * $data->children_count;

        $color = match (true) {
            $duration < $maxDurationTimeGood => VuetifyColor::SUCCESS,
            $duration < $maxDurationTimeMedium => VuetifyColor::WARNING,
            default => VuetifyColor::ERROR
        };

        if ($duration >= 1000) {
            $timestamp = Carbon::createFromTimestampMs($duration);

            $durationFormat = Str::of($timestamp->second)
                ->append(
                    '.',
                    $timestamp->millisecond,
                    ' sec'
                );
        } else {
            $durationFormat = Str::of($duration)->append(' ms');
        }

        return ItemBadgeComponent::create()
            ->setValue($durationFormat)
            ->setColor($color)
            ->setOutlined();
    }
}
