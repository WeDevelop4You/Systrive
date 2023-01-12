<?php

namespace App\Admin\Monitor\DataTables;

use Domain\Monitor\Enums\MonitorStatusType;
use Domain\Monitor\Mappings\MonitorTableMap;
use Domain\Monitor\Models\Monitor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractTable;
use Support\Client\Components\Misc\BadgeComponent;
use Support\Client\DataTable\Build\Column;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyTableAlignmentType;

class MonitorTable extends AbstractTable
{
    /**
     * @inheritDoc
     */
    protected function handle(): array
    {
        return [
            Column::create(trans('word.name.name'), 'name')
                ->setSortable()
                ->setSearchable(),
            Column::create(trans('word.status'), 'status')
                ->setSortable()
                ->setAlignment(VuetifyTableAlignmentType::CENTER)
                ->setSearchable(MonitorStatusType::class)
                ->setFormat(function (Monitor $data) {
                    return BadgeComponent::create()
                        ->setValue($data->status->getTranslation())
                        ->setColor($data->status->getColor())
                        ->setOutlined();
                }),
            Column::create(trans('word.duration.duration'), 'duration')
                ->setSortable(function (Builder $query, string $direction) {
                    return $query->orderBy(DB::raw("`ended` - `started`"), $direction);
                })
                ->setSearchable(function (Builder $query, string $search) {
                    return $query->orWhere(DB::raw("`ended` - `started`"), 'like', "%{$search}%");
                })
                ->setAlignment(VuetifyTableAlignmentType::CENTER)
                ->setFormat(function (Monitor $data) {
                    if (\is_null($data->ended)) {
                        return BadgeComponent::create()
                            ->setValue(trans('word.no.duration'))
                            ->setColor(VuetifyColor::LIGHT_GRAY)
                            ->setOutlined();
                    }

                    return $this->createDuration($data);
                }),
            Column::create(trans('word.created_at'), 'created_at')
                ->setSortable()
                ->setSearchable()
                ->setFormat(function (Monitor $data, string $key) {
                    return $data->getAttribute($key)->toDatetimeString();
                }),
        ];
    }

    /**
     * @param Monitor $data
     *
     * @return BadgeComponent
     */
    private function createDuration(Monitor $data): BadgeComponent
    {
        $duration = $data->duration;
        $color = match (true) {
            $duration < MonitorTableMap::DURATION_TIME_GOOD => VuetifyColor::SUCCESS,
            $duration < MonitorTableMap::DURATION_TIME_MEDIUM => VuetifyColor::WARNING,
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

        return BadgeComponent::create()
            ->setValue($durationFormat)
            ->setColor($color)
            ->setOutlined();
    }
}
