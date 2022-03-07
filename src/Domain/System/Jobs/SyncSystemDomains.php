<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemDomainTableMap;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Domain\System\Models\SystemUsageStatistic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Helpers\SystemStatisticHelper;
use Support\Helpers\Vesta\VestaAPIHelper;

class SyncSystemDomains extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    public function uniqueId(): string
    {
        return "{$this->system->username}_domains";
    }

    public function setup(System $system): void
    {
        $this->system = $system;
        $this->database = $system->domains;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommands::GET_USER_DOMAINS,
            $system->username
        );
    }

    /**
     * @param Collection         $vesta
     * @param Model|SystemDomain $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemDomain|Model $model): bool
    {
        return $vesta->keys()->contains($model->name);
    }

    /**
     * @param Collection         $vesta
     * @param Model|SystemDomain $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemDomain|Model $model): Collection
    {
        return $vesta;
    }

    /**
     * @param Collection $vesta
     *
     * @return void
     */
    protected function save(Collection $vesta): void
    {
        $domain = new SystemDomain();

        $domains = $vesta->map(function (array $data, string $name) use ($domain) {
            $domain->name = $name;
            $domain->system_id = $this->system->id;

            return $domain->attributesToArray();
        })->toArray();

        SystemDomain::upsert(
            $domains,
            SystemDomainTableMap::NAME
        );

        $this->system->load('domains');

        $usage = $this->system->domains->map(function (SystemDomain $systemDomain) use ($vesta) {
            $domain = $vesta->get($systemDomain->name);

            $totalMonthUsages = $systemDomain->usageStatistics()
                ->where(
                    SystemUsageStatisticTableMap::TYPE,
                    SystemUsageStatisticTableMap::BANDWIDTH_TYPE
                )->whereMonth(
                    SystemUsageStatisticTableMap::CREATED_AT,
                    Carbon::now()
                )->sum(SystemUsageStatisticTableMap::TOTAL);

            return [
                SystemStatisticHelper::create($systemDomain)
                    ->setType(SystemUsageStatisticTableMap::DISK_TYPE)
                    ->setTotal($domain['U_DISK'])
                    ->toArray(),
                SystemStatisticHelper::create($systemDomain)
                    ->setType(SystemUsageStatisticTableMap::BANDWIDTH_TYPE)
                    ->setTotal($domain['U_BANDWIDTH'] - $totalMonthUsages)
                    ->toArray(),
            ];
        })->flatten(1)->toArray();

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
}
