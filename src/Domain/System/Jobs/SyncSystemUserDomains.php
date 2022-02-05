<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Mappings\SystemUserDomainTableMap;
use Domain\System\Models\SystemUsageStatistic;
use Domain\System\Models\SystemUser;
use Domain\System\Models\SystemUserDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemUserDomains extends AbstractVestaSync
{
    /**
     * @var SystemUser
     */
    private SystemUser $systemUser;

    public function uniqueId(): string
    {
        return "{$this->systemUser->username}_domains";
    }

    public function setup(SystemUser $systemUser): void
    {
        $this->systemUser = $systemUser;
        $this->database = $systemUser->domains;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_USER_DOMAINS,
            $systemUser->username
        );
    }

    /**
     * @param Collection             $vesta
     * @param Model|SystemUserDomain $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemUserDomain|Model $model): bool
    {
        return $vesta->keys()->contains($model->name);
    }

    /**
     * @param Collection             $vesta
     * @param Model|SystemUserDomain $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemUserDomain|Model $model): Collection
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
        $domain = new SystemUserDomain();

        $domains = $vesta->map(function (array $data, string $name) use ($domain) {
            $domain->name = $name;
            $domain->system_user_id = $this->systemUser->id;

            return $domain->attributesToArray();
        })->toArray();

        SystemUserDomain::upsert(
            $domains,
            SystemUserDomainTableMap::NAME
        );

        $this->systemUser->load('domains');

        $usage = $this->systemUser->domains->map(function (SystemUserDomain $systemUserDomain) use ($vesta) {
            $domain = $vesta->get($systemUserDomain->name);

            $usage = new SystemUsageStatistic();
            $usage->date = Carbon::yesterday();
            $usage->statisticFrom()->associate($systemUserDomain);

            $disk = clone $usage;
            $bandwidth = clone $usage;

            $disk->type = SystemUsageStatisticTableMap::DISK_TYPE;
            $disk->total = $domain['U_DISK'];

            $bandwidth->type = SystemUsageStatisticTableMap::BANDWIDTH_TYPE;
            $bandwidth->total = $domain['U_BANDWIDTH'];

            return [
                $disk->attributesToArray(),
                $bandwidth->attributesToArray(),
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
