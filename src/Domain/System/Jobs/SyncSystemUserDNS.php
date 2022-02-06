<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemUserDNSTableMap;
use Domain\System\Models\SystemUser;
use Domain\System\Models\SystemUserDNS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemUserDNS extends AbstractVestaSync
{
    /**
     * @var SystemUser
     */
    private SystemUser $systemUser;

    public function uniqueId(): string
    {
        return "{$this->systemUser->username}_DNS";
    }

    public function setup(SystemUser $systemUser)
    {
        $this->systemUser = $systemUser;
        $this->database = $systemUser->dns;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_USER_DNS,
            $systemUser->username
        )->keys();
    }

    /**
     * @param Collection          $vesta
     * @param Model|SystemUserDNS $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemUserDNS|Model $model): bool
    {
        return $vesta->contains($model->domain);
    }

    /**
     * @param Collection          $vesta
     * @param Model|SystemUserDNS $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemUserDNS|Model $model): Collection
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
        $dns = new SystemUserDNS();

        $nameservers = $vesta->map(function (string $domainName) use ($dns) {
            $dns->domain = $domainName;
            $dns->system_user_id = $this->systemUser->id;

            return $dns->attributesToArray();
        })->toArray();

        SystemUserDNS::upsert($nameservers, [
            SystemUserDNSTableMap::DOMAIN,
        ]);
    }
}
