<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemDNSTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Services\Vesta;

;

class SyncSystemDNS extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    /**
     * SyncSystemDNS constructor.
     *
     * @param System $system
     */
    public function __construct(System $system)
    {
        $this->database = $system->dns;
        $this->system = $system->withoutRelations();

        $this->onQueue('system');
    }

    public function uniqueId(): string
    {
        return "{$this->system->username}_DNS";
    }

    protected function initialize(): void
    {
        $this->vesta = Vesta::api()->get(
            VestaCommands::GET_USER_DNS_DOMAINS,
            $this->system->username
        )->keys();
    }

    /**
     * @param Model|SystemDNS $model
     *
     * @return bool
     */
    protected function contains(SystemDNS|Model $model): bool
    {
        return $this->vesta->contains($model->name);
    }

    /**
     * @param Model|SystemDNS $model
     *
     * @return Collection
     */
    protected function reject(SystemDNS|Model $model): Collection
    {
        return $this->vesta->reject($model->name);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $dns = new SystemDNS();

        $nameservers = $this->vesta->map(function (string $domainName) use ($dns) {
            $dns->name = $domainName;
            $dns->system_id = $this->system->id;

            return $dns->attributesToArray();
        })->toArray();

        SystemDNS::upsert($nameservers, [
            SystemDNSTableMap::NAME,
        ]);
    }
}
