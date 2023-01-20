<?php

namespace Domain\System\Jobs;

use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Mappings\SystemMailDomainTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;
use Support\Utils\SystemStatistic;

class SyncSystemMailDomains extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    /**
     * SyncSystemMailDomains constructor.
     *
     * @param System $system
     */
    public function __construct(System $system)
    {
        $this->data = $system->mailDomains;
        $this->system = $system->withoutRelations();

        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Sync system mail domains for: {$this->system->username}";
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return "{$this->system->username}_mail_domains";
    }

    protected function initialize(): void
    {
        $this->syncData = Vesta::api()->get(
            VestaCommand::GET_USER_MAIL_DOMAINS,
            $this->system->username
        );
    }

    /**
     * @param Model|SystemMailDomain $model
     *
     * @return bool
     */
    protected function contains(SystemMailDomain|Model $model): bool
    {
        return $this->syncData->keys()->contains($model->name);
    }

    /**
     * @param Model|SystemMailDomain $model
     *
     * @return Collection
     */
    protected function reject(SystemMailDomain|Model $model): Collection
    {
        return $this->syncData;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $mailDomain = new SystemMailDomain();

        $mailDomains = $this->syncData->map(function (array $data, string $name) use ($mailDomain) {
            $mailDomain->name = $name;
            $mailDomain->system_id = $this->system->id;

            return $mailDomain->attributesToArray();
        })->toArray();

        SystemMailDomain::upsert($mailDomains, SystemMailDomainTableMap::COL_NAME);

        $this->system->load('mailDomains');

        $usage = $this->system->mailDomains->map(function (SystemMailDomain $systemMailDomain) {
            $mailDomain = $this->syncData->get($systemMailDomain->name);

            return SystemStatistic::create($systemMailDomain)
                ->setType(SystemUsageStatisticTypes::DISK)
                ->setTotal($mailDomain['U_DISK'])
                ->toArray();
        })->toArray();

        $this->upsertStatistics($usage);
    }
}
