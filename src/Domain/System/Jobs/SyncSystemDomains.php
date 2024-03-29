<?php

namespace Domain\System\Jobs;

use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Mappings\SystemDomainTableMap;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;
use Support\Utils\SystemStatistic;

class SyncSystemDomains extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    /**
     * SyncSystemDomains constructor.
     *
     * @param System $system
     */
    public function __construct(System $system)
    {
        $this->data = $system->domains;
        $this->system = $system->withoutRelations();

        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Sync system domains for: {$this->system->username}";
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return "{$this->system->username}_domains";
    }

    protected function initialize(): void
    {
        $this->syncData = Vesta::api()->get(
            VestaCommand::GET_USER_DOMAINS,
            $this->system->username
        );
    }

    /**
     * @param Model|SystemDomain $model
     *
     * @return bool
     */
    protected function contains(SystemDomain|Model $model): bool
    {
        return $this->syncData->keys()->contains($model->name);
    }

    /**
     * @param Model|SystemDomain $model
     *
     * @return Collection
     */
    protected function reject(SystemDomain|Model $model): Collection
    {
        return $this->syncData;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $domain = new SystemDomain();

        $domains = $this->syncData->map(function (array $data, string $name) use ($domain) {
            $domain->name = $name;
            $domain->system_id = $this->system->id;

            return $domain->attributesToArray();
        })->toArray();

        SystemDomain::upsert($domains, SystemDomainTableMap::COL_NAME);

        $this->system->load('domains');

        $usage = $this->system->domains->map(function (SystemDomain $systemDomain) {
            $domain = $this->syncData->get($systemDomain->name);

            $totalMonthUsages = $systemDomain->usageStatistics()
                ->where(
                    SystemUsageStatisticTableMap::COL_TYPE,
                    SystemUsageStatisticTypes::BANDWIDTH
                )->whereMonth(
                    SystemUsageStatisticTableMap::COL_CREATED_AT,
                    Carbon::now()
                )->sum(SystemUsageStatisticTableMap::COL_TOTAL);

            return [
                SystemStatistic::create($systemDomain)
                    ->setType(SystemUsageStatisticTypes::DISK)
                    ->setTotal($domain['U_DISK'])
                    ->toArray(),
                SystemStatistic::create($systemDomain)
                    ->setType(SystemUsageStatisticTypes::BANDWIDTH)
                    ->setTotal($domain['U_BANDWIDTH'] - $totalMonthUsages)
                    ->toArray(),
            ];
        })->flatten(1)->toArray();

        $this->upsertStatistics($usage);
    }
}
