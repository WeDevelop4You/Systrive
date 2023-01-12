<?php

namespace Domain\Cms\Observers;

use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Support\Enums\VestaCommand;
use Support\Exceptions\Custom\Vesta\VestaCommandException;
use Support\Services\Vesta;

class CmsForceDeletedObserver
{
    /**
     * @throws VestaCommandException
     */
    public function forceDeleted(Cms $cms): void
    {
        /** @var Company $company */
        $company = $cms->company()->with('system')->first();

        Vesta::api()->post(
            VestaCommand::DELETE_DATABASE,
            $company->system->username,
            $cms->username->decrypt
        );
    }
}
