<?php

namespace App\Admin\System\Domain\Controllers;

use App\Admin\System\Domain\Responses\SystemDomainEditResponse;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Illuminate\Http\JsonResponse;

class SystemDomainEditController
{
    /**
     * @param Company      $company
     * @param System       $system
     * @param SystemDomain $domain
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemDomain $domain): JsonResponse
    {
        return SystemDomainEditResponse::create($company, $system, $domain)->toJson();
    }
}
