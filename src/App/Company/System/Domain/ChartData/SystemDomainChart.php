<?php

namespace App\Company\System\Domain\ChartData;

use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Models\SystemDomain;
use Support\Abstracts\AbstractChart;

class SystemDomainChart extends AbstractChart
{
    /**
     * DomainChart constructor.
     *
     * @param SystemDomain              $domain
     * @param SystemUsageStatisticTypes $type
     */
    protected function __construct(
            private readonly SystemDomain $domain,
            private readonly SystemUsageStatisticTypes $type
        ) {
            //
    }

    protected function handle(): void
    {
        if (!$this->validate()) {
            $this->setData([]);

            return;
        }

        $usages = $this->domain->usageStatistics()
            ->whereDate(
                SystemUsageStatisticTableMap::COL_DATE,
                '>=',
                $this->startDate->toDateString(),
            )->where(
                SystemUsageStatisticTableMap::COL_TYPE,
                $this->type
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

    /**
     * @return bool
     */
    private function validate(): bool
    {
        return \in_array($this->type, [
            SystemUsageStatisticTypes::DISK,
            SystemUsageStatisticTypes::BANDWIDTH,
        ]);
    }
}
