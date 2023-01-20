<?php

namespace Domain\System\Jobs;

use Domain\System\Mappings\SystemTableMap;
use Domain\System\Models\System;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Support\Abstracts\AbstractVestaSync;
use Support\Enums\VestaCommand;
use Support\Exceptions\Custom\Vesta\VestaConnectionFailedException;
use Support\Services\Vesta;

class SyncSystemUsers extends AbstractVestaSync
{
    private bool $withData;

    public function __construct(bool $withData = false)
    {
        $this->withData = $withData;
        $this->onQueue('system');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Sync system users';
    }

    /**
     * @return string
     */
    public function uniqueId(): string
    {
        return 'system_users';
    }

    /**
     * @throws VestaConnectionFailedException
     */
    protected function initialize(): void
    {
        $this->data = System::all();
        $this->syncData = Vesta::api()->get(
            VestaCommand::GET_SYSTEM_USERS
        );
    }

    /**
     * @param Model|System $model
     *
     * @return bool
     */
    protected function contains(System|Model $model): bool
    {
        return $this->syncData->contains($model->username);
    }

    /**
     * @param Model|System $model
     *
     * @return Collection
     */
    protected function reject(System|Model $model): Collection
    {
        return $this->syncData->reject($model->username);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $systems = $this->syncData->map(function (string $username) {
            $system = new System();
            $system->username = $username;

            return $system->attributesToArray();
        })->toArray();

        System::upsert($systems, [SystemTableMap::COL_USERNAME]);
    }

    /**
     * @return void
     */
    protected function after(): void
    {
        if ($this->withData) {
            SyncSystemData::dispatch();
        }
    }
}
