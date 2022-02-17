<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemMailDomainTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

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
            VestaCommandsHelper::GET_USER_MAIL_DOMAINS,
            $system->username
        )->keys();
    }

    /**
     * @param Collection             $vesta
     * @param Model|SystemMailDomain $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemMailDomain|Model $model): bool
    {
        return $vesta->contains($model->name);
    }

    /**
     * @param Collection             $vesta
     * @param Model|SystemMailDomain $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemMailDomain|Model $model): Collection
    {
        return $vesta->reject($model->name);
    }

    /**
     * @param Collection $vesta
     *
     * @return void
     */
    protected function save(Collection $vesta): void
    {
        $mailDomain = new SystemMailDomain();

        $mailDomains = $vesta->map(function (string $domainName) use ($mailDomain) {
            $mailDomain->name = $domainName;
            $mailDomain->system_id = $this->system->id;

            return $mailDomain->attributesToArray();
        })->toArray();

        SystemMailDomain::upsert($mailDomains, [
            SystemMailDomainTableMap::NAME,
        ]);
    }
}