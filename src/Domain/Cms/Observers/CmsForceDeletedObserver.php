<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\UnableToDeleteDirectory;
use League\Flysystem\UnableToDeleteFile;
use Sentry;
use Support\Enums\VestaCommand;
use Support\Exceptions\Custom\Vesta\VestaCommandException;
use Support\Exceptions\Custom\Vesta\VestaConnectionFailedException;
use Support\Services\Vesta;

class CmsForceDeletedObserver
{
    /**
     * @throws VestaConnectionFailedException
     * @throws VestaCommandException
     */
    public function forceDeleted(Cms $cms): void
    {
        /** @var Company $company */
        $company = $cms->company()->with('system')->first();

        try {
            Vesta::api()->post(
                VestaCommand::DELETE_DATABASE,
                $company->system->username,
                $cms->username->decrypt
            );
        } finally {
            try {
                Storage::deleteDirectory($cms->storagePath());
            } catch (UnableToDeleteDirectory $e) {
                Sentry::captureException($e);
            }
        }
    }
}
