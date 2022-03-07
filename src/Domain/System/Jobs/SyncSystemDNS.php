<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemDNSTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Helpers\Vesta\VestaAPIHelper;

;

class SyncSystemDNS extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    public function uniqueId(): string
    {
        return "{$this->system->username}_DNS";
    }

    public function setup(System $system)
    {
        $this->system = $system;
        $this->database = $system->dns;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommands::GET_USER_DNS_DOMAINS,
            $system->username
        )->keys();
    }

    /**
     * @param Collection      $vesta
     * @param Model|SystemDNS $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemDNS|Model $model): bool
    {
        return $vesta->contains($model->domain);
    }

    /**
     * @param Collection      $vesta
     * @param Model|SystemDNS $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemDNS|Model $model): Collection
    {
        return $vesta->reject($model->domain);
    }

    /**
     * @param Collection $vesta
     *
     * @return void
     */
    protected function save(Collection $vesta): void
    {
        $dns = new SystemDNS();

        $nameservers = $vesta->map(function (string $domainName) use ($dns) {
            $dns->domain = $domainName;
            $dns->system_id = $this->system->id;

            return $dns->attributesToArray();
        })->toArray();

        SystemDNS::upsert($nameservers, [
            SystemDNSTableMap::NAME,
        ]);
    }
}
