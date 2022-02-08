<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemDatabaseTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Helpers\Vesta\VestaAPIHelper;
use Support\Helpers\Vesta\VestaCommandsHelper;

class SyncSystemDatabases extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    public function uniqueId(): string
    {
        return "{$this->system->username}_databases";
    }

    public function setup(System $system)
    {
        $this->system = $system;
        $this->database = $system->databases;
        $this->vesta = VestaAPIHelper::create()->getCommand(
            VestaCommandsHelper::GET_USER_DATABASES,
            $system->username
        )->keys();
    }

    /**
     * @param Collection           $vesta
     * @param Model|SystemDatabase $model
     *
     * @return bool
     */
    protected function contains(Collection $vesta, SystemDatabase|Model $model): bool
    {
        return $vesta->contains($model->name);
    }

    /**
     * @param Collection           $vesta
     * @param Model|SystemDatabase $model
     *
     * @return Collection
     */
    protected function reject(Collection $vesta, SystemDatabase|Model $model): Collection
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
        $database = new SystemDatabase();

        $databases = $vesta->map(function (string $name) use ($database) {
            $database->name = $name;
            $database->system_id = $this->system->id;

            return $database->attributesToArray();
        })->toArray();

        SystemDatabase::upsert($databases, [
            SystemDatabaseTableMap::NAME,
        ]);
    }
}
