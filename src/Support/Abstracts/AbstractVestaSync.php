<?php

namespace Support\Abstracts;

use Domain\Monitor\Interfaces\ShouldBeNamed;
use Domain\Monitor\Interfaces\WithMonitoring;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Models\SystemUsageStatistic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Support\Exceptions\Custom\Vesta\VestaConnectionFailedException;
use Throwable;

abstract class AbstractVestaSync implements ShouldQueue, ShouldBeUnique, ShouldBeNamed, WithMonitoring
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var Collection
     */
    protected Collection $data;

    /**
     * @var Collection
     */
    protected Collection $syncData;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->initialize();

        $this->data->each(function (Model $model) {
            $this->contains($model)
                ? $this->syncData = $this->reject($model)
                : $model->delete();
        });

        $this->save();

        $this->after();
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     *
     * @return void
     */
    public function failed(Throwable $exception): void
    {
        if ($exception instanceof VestaConnectionFailedException) {
            $this->delete();
        }
    }

    /**
     * @return void
     */
    protected function initialize(): void
    {
        //
    }

    /**
     * @return void
     */
    protected function after(): void
    {
        //
    }

    /**
     * @param array $usage
     *
     * @return void
     */
    protected function upsertStatistics(array $usage): void
    {
        SystemUsageStatistic::upsert(
            $usage,
            [
                SystemUsageStatisticTableMap::COL_MODEL_ID,
                SystemUsageStatisticTableMap::COL_MODEL_TYPE,
                SystemUsageStatisticTableMap::COL_TYPE,
                SystemUsageStatisticTableMap::COL_DATE,
            ],
            [
                SystemUsageStatisticTableMap::COL_TOTAL,
            ]
        );
    }

    /**
     * @return string
     */
    abstract public function uniqueId(): string;

    /**
     * @param Model $model
     *
     * @return bool
     */
    abstract protected function contains(Model $model): bool;

    /**
     * @param Model $model
     *
     * @return Collection
     */
    abstract protected function reject(Model $model): Collection;

    /**
     * @return void
     */
    abstract protected function save(): void;
}
