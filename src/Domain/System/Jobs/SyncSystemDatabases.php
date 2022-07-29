<?php

namespace Domain\System\Jobs;

use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Mappings\SystemDatabaseTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommands;
use Support\Helpers\SystemStatisticHelper;
use Support\Services\Vesta;

class SyncSystemDatabases extends AbstractVestaSync
{
    /**
     * @var System
     */
    private System $system;

    /**
     * SyncSystemDatabases constructor.
     *
     * @param System $system
     */
    public function __construct(System $system)
    {
        $this->database = $system->databases;
        $this->system = $system->withoutRelations();

        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return "{$this->system->username}_databases";
    }

    protected function initialize(): void
    {
        $this->vesta = Vesta::api()->get(
            VestaCommands::GET_USER_DATABASES,
            $this->system->username
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
                ->setType(SystemUsageStatisticTypes::DISK)
                ->setTotal($database['U_DISK'])
                ->toArray();
        })->toArray();

        $this->upsertStatistics($usage);
    }
}
