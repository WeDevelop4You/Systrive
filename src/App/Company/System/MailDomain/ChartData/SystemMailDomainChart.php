<?php

    namespace App\Company\System\MailDomain\ChartData;

    use Domain\System\Enums\SystemUsageStatisticTypes;
    use Domain\System\Mappings\SystemUsageStatisticTableMap;
    use Domain\System\Models\SystemMailDomain;
    use Support\Abstracts\AbstractChart;

    class SystemMailDomainChart extends AbstractChart
    {
        protected int $period = 4;

        /**
         * DomainChart constructor.
         *
         * @param SystemMailDomain $mailDomain
         */
        protected function __construct(
            private readonly SystemMailDomain $mailDomain
        ) {
            //
        }

        protected function handle(): void
        {
            $usages = $this->mailDomain->usageStatistics()
                ->whereDate(
                    SystemUsageStatisticTableMap::COL_DATE,
                    '>=',
                    $this->startDate->toDateString(),
                )->where(
                    SystemUsageStatisticTableMap::COL_TYPE,
                    SystemUsageStatisticTypes::DISK,
                )->orderBy(
                    SystemUsageStatisticTableMap::COL_DATE
                )->get();

            $dataset = $this->periodRange->map(function (string $date) use ($usages) {
                $usage = $usages->firstWhere(
                    SystemUsageStatisticTableMap::COL_DATE,
                    $date
                );

                if (\is_null($usage)) {
                    return 0;
                }

                return $usage->total;
            })->toArray();

            $this->setData($dataset);
        }
    }
