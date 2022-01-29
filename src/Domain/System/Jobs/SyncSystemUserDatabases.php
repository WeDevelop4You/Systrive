<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemUserDatabaseTableMap;
use Domain\System\Models\SystemUser;
use Domain\System\Models\SystemUserDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemUserDatabases extends AbstractVestaSync
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private SystemUser $systemUser
    ) {
        $this->database = $systemUser->databases;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_USER_DATABASES,
            $systemUser->username
        )->keys();
    }

    /**
     * @param Collection               $vesta
     * @param Model|SystemUserDatabase $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemUserDatabase|Model $model): bool
    {
        return $vesta->contains($model->name);
    }

    /**
     * @param Collection               $vesta
     * @param Model|SystemUserDatabase $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemUserDatabase|Model $model): Collection
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
        $database = new SystemUserDatabase();

        $databases = $vesta->map(function (string $name) use ($database) {
            $database->name = $name;
            $database->system_user_id = $this->systemUser->id;

            return $database->attributesToArray();
        })->toArray();

        SystemUserDatabase::upsert($databases, [
            SystemUserDatabaseTableMap::NAME,
        ]);
    }
}
