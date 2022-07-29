<?php

    namespace Support\Abstracts;

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

    abstract class AbstractVestaSync implements ShouldQueue, ShouldBeUnique
    {
        use Dispatchable;
        use InteractsWithQueue;
        use Queueable;
        use SerializesModels;

        /**
         * @var Collection
         */
        protected Collection $database;

        /**
         * @var Collection
         */
        protected Collection $vesta;

        /**
         * @return void
         */
        protected function initialize(): void
        {
            //
        }

        /**
         * Execute the job.
         *
         * @return void
         */
        public function handle(): void
        {
            $this->initialize();

            $this->database->each(function (Model $model) {
                $this->contains($model)
                    ? $this->vesta = $this->reject($model)
                    : $model->delete();
            });

            $this->save();
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
                    SystemUsageStatisticTableMap::MODEL_ID,
                    SystemUsageStatisticTableMap::MODEL_TYPE,
                    SystemUsageStatisticTableMap::TYPE,
                    SystemUsageStatisticTableMap::DATE,
                ],
                [
                    SystemUsageStatisticTableMap::TOTAL,
                ]
            );
        }

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
