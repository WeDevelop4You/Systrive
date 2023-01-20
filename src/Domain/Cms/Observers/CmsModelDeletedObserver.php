<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Mappings\CmsFileTableMap;
use Domain\Cms\Models\CmsFile;
use Domain\Cms\Models\CmsModel;
use Illuminate\Database\Eloquent\Collection;
use Support\Services\Cms;

class CmsModelDeletedObserver
{
    /**
     * @param CmsModel $model
     *
     * @return void
     */
    public function deleted(CmsModel $model): void
    {
        $table = Cms::getTable();

        if ($table->isBackup()) {
            /** @var Collection $files */
            /** @var Collection $backups */
            [$files, $backups] = $table->files()->withTrashed()->get()->partition(
                fn (CmsFile $file) => $file->table_id === $model->id
            );

            $files->each(function (CmsFile $file) use ($backups) {
                $exist = $backups->where(CmsFileTableMap::COL_PATH, $file->path)->isNotEmpty();

                if ($exist) {
                    $file->forceDeleteQuietly();
                } else {
                    $file->forceDelete();
                }
            });
        } else {
            $model->files->each->forceDelete();
        }
    }
}
