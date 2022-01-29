<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemUserDomainTableMap;
use Domain\System\Models\SystemUser;
use Domain\System\Models\SystemUserDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemUserDomains extends AbstractVestaSync
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private SystemUser $systemUser
    ) {
        $this->database = $systemUser->domains;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_USER_DOMAINS,
            $systemUser->username
        )->keys();
    }

    /**
     * @param Collection             $vesta
     * @param Model|SystemUserDomain $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemUserDomain|Model $model): bool
    {
        return $vesta->contains($model->name);
    }

    /**
     * @param Collection             $vesta
     * @param Model|SystemUserDomain $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemUserDomain|Model $model): Collection
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
        $domain = new SystemUserDomain();

        $domains = $vesta->map(function (string $domainName) use ($domain) {
            $domain->name = $domainName;
            $domain->system_user_id = $this->systemUser->id;

            return $domain->attributesToArray();
        })->toArray();

        SystemUserDomain::upsert($domains, [
            SystemUserDomainTableMap::NAME,
        ]);
    }
}
