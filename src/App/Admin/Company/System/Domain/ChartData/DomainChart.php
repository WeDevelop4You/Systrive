<?php

    namespace App\Admin\Company\System\Domain\ChartData;

    use Carbon\CarbonPeriod;
    use Domain\System\Mappings\SystemUsageStatisticTableMap;
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
        protected function __construct(
            private SystemDomain $domain
        ) {
            //
        }

        protected function handle(): void
        {
            $addDay = (int) Carbon::now()->lt(Carbon::today()->addHours(4));

            $endDate = Carbon::now()->subDays($addDay);
            $startDate = Carbon::now()->subWeeks(2)->subDays($addDay);
            $period = Collection::make(CarbonPeriod::create($startDate, $endDate));


            $periodDates = $period->map(function (Carbon $date) {
                return $date->toDateString();
            });

            $this->setLabels($periodDates->toArray());

            $this->setData(
                $this->domain->usageStatistics()
                    ->whereDate(
                        SystemUsageStatisticTableMap::DATE,
                        '>=',
                        $startDate->toDateString(),
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
                    ])->map(function (Collection $dates) use ($periodDates) {
                        return $periodDates->map(function (string $date) use ($dates) {
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
