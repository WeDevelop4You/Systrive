<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemUserTableMap;
use Domain\System\Models\SystemUser;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemUsers extends AbstractVestaSync
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct()
    {
        $this->database = SystemUser::all();
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_SYSTEM_USERS
        );
    }

    /**
     * @param Collection       $vesta
     * @param Model|SystemUser $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemUser|Model $model): bool
    {
        return $vesta->contains($model->username);
    }

    /**
     * @param Collection       $vesta
     * @param Model|SystemUser $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemUser|Model $model): Collection
    {
        return $vesta->reject($model->username);
    }

    /**
     * @param Collection $vesta
     *
     * @return void
     */
    protected function save(Collection $vesta): void
    {
        $systemUser = new SystemUser();

        $systemUsers = $vesta->map(function (string $username) use ($systemUser) {
            $systemUser->username = $username;

            return $systemUser->attributesToArray();
        })->toArray();

        SystemUser::upsert($systemUsers, [SystemUserTableMap::USERNAME]);
    }
}
