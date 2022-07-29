<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemTableMap;
use Domain\System\Models\System;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Services\Vesta;

class SyncSystem extends AbstractVestaSync
{
    public function __construct()
    {
        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return "system_users";
    }

    protected function initialize(): void
    {
        $this->database = System::all();
        $this->vesta = Vesta::api()->get(
            VestaCommands::GET_SYSTEM_USERS
        );
    }

    /**
     * @param Model|System $model
     *
     * @return bool
     */
    protected function contains(System|Model $model): bool
    {
        return $this->vesta->contains($model->username);
    }

    /**
     * @param Model|System $model
     *
     * @return Collection
     */
    protected function reject(System|Model $model): Collection
    {
        return $this->vesta->reject($model->username);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $system = new System();

        $systems = $this->vesta->map(function (string $username) use ($system) {
            $system->username = $username;

            return $system->attributesToArray();
        })->toArray();

        System::upsert($systems, [SystemTableMap::USERNAME]);
    }
}
