<?php

namespace Domain\System\Jobs;

use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Mappings\SystemDatabaseTableMap;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommand;
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
        $this->data = $system->databases;
        $this->system = $system->withoutRelations();

        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "Sync system databases for: {$this->system->username}";
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
        $this->syncData = Vesta::api()->get(
            VestaCommand::GET_USER_DATABASES,
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
        return $this->syncData->keys()->contains($model->name);
    }

    /**
     * @param Model|SystemDatabase $model
     *
     * @return Collection
     */
    protected function reject(SystemDatabase|Model $model): Collection
    {
        return $this->syncData;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $database = new SystemDatabase();

        $databases = $this->syncData->map(function (array $data, string $name) use ($database) {
            $database->name = $name;
            $database->system_id = $this->system->id;

            return $database->attributesToArray();
        })->toArray();

        SystemDatabase::upsert($databases, SystemDatabaseTableMap::COL_NAME);

        $this->system->load('databases');

        $usage = $this->system->databases->map(function (SystemDatabase $systemDatabase) {
            $database = $this->syncData->get($systemDatabase->name);

            return SystemStatisticHelper::create($systemDatabase)
                ->setType(SystemUsageStatisticTypes::DISK)
                ->setTotal($database['U_DISK'])
                ->toArray();
        })->toArray();

        $this->upsertStatistics($usage);
    }
}
