<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemUserMailDomainTableMap;
use Domain\System\Models\SystemUser;
use Domain\System\Models\SystemUserMailDomain;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemUserMailDomains extends AbstractVestaSync
{
    /**
     * @var SystemUser
     */
    private SystemUser $systemUser;

    public function uniqueId(): string
    {
        return "{$this->systemUser->username}_mail_domains";
    }

    public function setup(SystemUser $systemUser)
    {
        $this->systemUser = $systemUser;
        $this->database = $systemUser->mailDomains;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_USER_MAIL_DOMAINS,
            $systemUser->username
        )->keys();
    }

    /**
     * @param Collection                 $vesta
     * @param Model|SystemUserMailDomain $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemUserMailDomain|Model $model): bool
    {
        return $vesta->contains($model->name);
    }

    /**
     * @param Collection                 $vesta
     * @param Model|SystemUserMailDomain $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemUserMailDomain|Model $model): Collection
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
        $mailDomain = new SystemUserMailDomain();

        $mailDomains = $vesta->map(function (string $domainName) use ($mailDomain) {
            $mailDomain->name = $domainName;
            $mailDomain->system_user_id = $this->systemUser->id;

            return $mailDomain->attributesToArray();
        })->toArray();

        SystemUserMailDomain::upsert($mailDomains, [
            SystemUserMailDomainTableMap::NAME,
        ]);
    }
}
