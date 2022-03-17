<?php

    namespace App\Admin\System\Database\ChartData;

    use Domain\System\Mappings\SystemUsageStatisticTableMap;
    use Domain\System\Models\SystemDatabase;
    use Illuminate\Support\Collection;
    use Support\Abstracts\AbstractChart;

    class DatabaseChart extends AbstractChart
    {
        /**
         * DomainChart constructor.
         *
         * @param SystemDatabase $database
         */
        protected function __construct(
            private SystemDatabase $database
        ) {
            //
        }

        protected function handle(): void
        {
            $this->setData(
                $this->database->usageStatistics()
                    ->whereDate(
                        SystemUsageStatisticTableMap::DATE,
                        '>=',
                        $this->startDate->toDateString(),
                    )->whereIn(
                        SystemUsageStatisticTableMap::TYPE,
                        [
                            SystemUsageStatisticTableMap::DISK_TYPE,
                            SystemUsageStatisticTableMap::BANDWIDTH_TYPE,
                        ]
                    )
                    ->get()
                    ->groupBy([
                        SystemUsageStatisticTableMap::TYPE,
                    ])->map(function (Collection $dates) {
                        return $this->periodRange->map(function (string $date) use ($dates) {
                            $usage = $dates->firstWhere(
                                SystemUsageStatisticTableMap::DATE,
                                $date
                            );

                            if (is_null($usage)) {
                                return 0;
                            }

                            return $usage->total;
                        });
                    })->toArray()
            );
        }
    }
