<?php

    namespace App\Admin\Company\System\Domain\ChartData;

    use Carbon\CarbonPeriod;
    use Domain\System\Mappings\SystemStatisticTableMap;
    use Domain\System\Models\SystemDomain;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Collection;
    use Support\Abstracts\AbstractChart;

    class DomainChart extends AbstractChart
    {
        /**
         * DomainChart constructor.
         *
         * @param SystemDomain $domain
         */
        public function __construct(
            private SystemDomain $domain
        ) {
            //
        }

        protected function handle(): void
        {
            $endDate = Carbon::now();
            $startDate = Carbon::now()->subWeeks(2);
            $period = new Collection(CarbonPeriod::create($startDate, $endDate));


            $periodDates = $period->map(function (Carbon $date) {
                return $date->toDateString();
            });

            $this->setLabels($periodDates->toArray());

            $this->setData(
                $this->domain->usageStatistics()
                    ->whereDate(
                        SystemStatisticTableMap::DATE,
                        '>=',
                        $startDate->toDateString(),
                    )->whereIn(
                        SystemStatisticTableMap::TYPE,
                        [
                            SystemStatisticTableMap::DISK_TYPE,
                            SystemStatisticTableMap::BANDWIDTH_TYPE,
                        ]
                    )
                    ->get()
                    ->groupBy([
                        SystemStatisticTableMap::TYPE,
                    ])->map(function (Collection $dates) use ($periodDates) {
                        return $periodDates->map(function (string $date) use ($dates) {
                            $usage = $dates->firstWhere(
                                SystemStatisticTableMap::DATE,
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
