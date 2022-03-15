<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemDatabaseTableMap;
use Domain\System\Mappings\SystemUsageStatisticTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Helpers\SystemStatisticHelper;
use Support\Helpers\Vesta\VestaAPIHelper;

;

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
            VestaCommands::GET_USER_DATABASES,
            $system->username
        );
    }

    /**
     * @param Model|SystemDatabase $model
     *
     * @return bool
     */
    protected function contains(SystemDatabase|Model $model): bool
    {
        return $this->vesta->keys()->contains($model->name);
    }

    /**
     * @param Model|SystemDatabase $model
     *
     * @return Collection
     */
    protected function reject(SystemDatabase|Model $model): Collection
    {
        return $this->vesta;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $database = new SystemDatabase();

        $databases = $this->vesta->map(function (array $data, string $name) use ($database) {
            $database->name = $name;
            $database->system_id = $this->system->id;

            return $database->attributesToArray();
        })->toArray();

        SystemDatabase::upsert($databases, SystemDatabaseTableMap::NAME);

        $this->system->load('databases');

        $usage = $this->system->databases->map(function (SystemDatabase $systemDatabase) {
            $database = $this->vesta->get($systemDatabase->name);

            return SystemStatisticHelper::create($systemDatabase)
                ->setType(SystemUsageStatisticTableMap::DISK_TYPE)
                ->setTotal($database['U_DISK'])
                ->toArray();
        })->toArray();

        $this->upsertStatistics($usage);
    }
}
