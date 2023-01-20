<?php

namespace Domain\Company\Observers;

use Domain\Company\Models\Company;
use Illuminate\Support\Str;

class CompanySavingObserver
{
    /**
     * @param Company $company
     *
     * @return void
     */
    public function saving(Company $company): void
    {
        $company->slug = Str::slug($company->name);
    }
}
