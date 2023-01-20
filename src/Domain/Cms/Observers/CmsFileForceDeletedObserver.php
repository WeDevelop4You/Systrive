<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Models\CmsFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\UnableToDeleteFile;
use Sentry;

class CmsFileForceDeletedObserver
{
    /**
     * @param CmsFile $file
     *
     * @return void
     */
    public function forceDeleted(CmsFile $file): void
    {
        try {
            Storage::delete($file->path);
        } catch (UnableToDeleteFile $e) {
            Sentry::captureException($e);
        }
    }
}
