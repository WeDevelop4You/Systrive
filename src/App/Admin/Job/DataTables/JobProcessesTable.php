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
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;
use Support\Helpers\DataTable\Build\Column;
use Support\Response\Components\Items\ItemBadgeComponent;

class JobProcessesTable extends AbstractTable
{
    /**
     * @inheritDoc
     */
    protected function handle(): array
    {
        return [
            Column::index(),
            Column::create(trans('word.name'), 'name')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (JobOperation $data) {
                    return $data->name;
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
                    if (\is_null($data->end_time)) {
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
            Column::create(trans('word.created_at'), 'created_at')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (JobOperation $data, string $key) {
                    return $data->getAttribute($key)->toDatetimeString();
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
        $color = match (true) {
            $duration < JobOperationTableMap::DURATION_TIME_GOOD => VuetifyColor::SUCCESS,
            $duration < JobOperationTableMap::DURATION_TIME_MEDIUM => VuetifyColor::WARNING,
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
