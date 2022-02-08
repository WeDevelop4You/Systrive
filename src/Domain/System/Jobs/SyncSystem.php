<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemTableMap;
use Domain\System\Models\System;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystem extends AbstractVestaSync
{
    public function uniqueId(): string
    {
        return "system_users";
    }

    /**
     * @return void
     */
    protected function setup(): void
    {
        $this->database = System::all();
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_SYSTEM_USERS
        );
    }

    /**
     * @param Collection   $vesta
     * @param Model|System $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, System|Model $model): bool
    {
        return $vesta->contains($model->username);
    }

    /**
     * @param Collection   $vesta
     * @param Model|System $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, System|Model $model): Collection
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
        $system = new System();

        $systems = $vesta->map(function (string $username) use ($system) {
            $system->username = $username;

            return $system->attributesToArray();
        })->toArray();

        System::upsert($systems, [SystemTableMap::USERNAME]);
    }
}
