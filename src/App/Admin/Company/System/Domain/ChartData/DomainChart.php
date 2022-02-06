<?php

    namespace App\Admin\Company\System\Domain\ChartData;

    use Carbon\CarbonPeriod;
    use Domain\System\Mappings\SystemUsageStatisticTableMap;
    use Domain\System\Models\SystemUserDomain;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Collection;
    use Support\Abstracts\AbstractChart;

    class DomainChart extends AbstractChart
    {
        protected function handle(): void
        {
            $domain = SystemUserDomain::find(7);

            $endDate = Carbon::now();
            $startDate = Carbon::now()->subWeeks(2);
            $period = new Collection(CarbonPeriod::create($startDate, $endDate));


            $periodDates = $period->map(function (Carbon $date) {
                return $date->toDateString();
            });

            $this->setLabels($periodDates->toArray());

            $this->setData(
                $domain->usageStatistics()
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
