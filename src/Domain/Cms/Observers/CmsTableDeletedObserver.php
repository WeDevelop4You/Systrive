<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Mappings\CmsFileTableMap;
use Domain\Cms\Models\CmsFile;
use Domain\Cms\Models\CmsTable;

class CmsTableDeletedObserver
{
    public function deleted(CmsTable $table): void
    {
        $files = $table->files()->get();

        if ($table->isBackup()) {
            // This is to prevent to many requests to AWS s3 bucket when the table has backups
            $uniques = $files->unique(CmsFileTableMap::COL_PATH)
                ->pluck(CmsFileTableMap::COL_ID)
                ->toArray();

            $files->each(function (CmsFile $file) use ($uniques) {
                if (in_array($file->id, $uniques)) {
                    $file->forceDelete();
                } else {
                    $file->forceDeleteQuietly();
                }
            });
        } else {
            $files->each->forceDelete();
        }
    }
}
