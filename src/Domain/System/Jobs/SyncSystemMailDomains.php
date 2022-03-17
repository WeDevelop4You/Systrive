<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemMailDomainTableMap;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Helpers\SystemStatisticHelper;
use Support\Helpers\Vesta\VestaAPIHelper;

;

class SyncSystemMailDomains extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    public function uniqueId(): string
    {
        return "{$this->system->username}_mail_domains";
    }

    public function setup(System $system)
    {
        $this->system = $system;
        $this->database = $system->mailDomains;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommands::GET_USER_MAIL_DOMAINS,
            $system->username
        );
    }

    /**
     * @param Model|SystemMailDomain $model
     *
     * @return bool
     */
    protected function contains(SystemMailDomain|Model $model): bool
    {
        return $this->vesta->keys()->contains($model->name);
    }

    /**
     * @param Model|SystemMailDomain $model
     *
     * @return Collection
     */
    protected function reject(SystemMailDomain|Model $model): Collection
    {
        return $this->vesta;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $mailDomain = new SystemMailDomain();

        $mailDomains = $this->vesta->map(function (array $data, string $name) use ($mailDomain) {
            $mailDomain->name = $name;
            $mailDomain->system_id = $this->system->id;

            return $mailDomain->attributesToArray();
        })->toArray();

        SystemMailDomain::upsert($mailDomains, SystemMailDomainTableMap::NAME);

        $this->system->load('mailDomains');

        $usage = $this->system->mailDomains->map(function (SystemMailDomain $systemMailDomain) {
            $mailDomain = $this->vesta->get($systemMailDomain->name);

            return SystemStatisticHelper::create($systemMailDomain)
                ->setType(SystemUsageStatisticTableMap::DISK_TYPE)
                ->setTotal($mailDomain['U_DISK'])
                ->toArray();
        })->toArray();

        $this->upsertStatistics($usage);
    }
}
