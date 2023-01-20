<?php

namespace App\Company\System\Domain\Controllers;

use App\Company\System\Domain\ChartData\SystemDomainChart;
use Domain\Company\Models\Company;
use Domain\System\Enums\SystemUsageStatisticTypes;
use Domain\System\Models\System;
use Domain\System\Models\SystemDomain;
use Illuminate\Http\JsonResponse;
use Support\Client\Response;

class SystemDomainUsageController
{
    /**
     * @param Company                   $company
     * @param System                    $system
     * @param SystemDomain              $domain
     * @param SystemUsageStatisticTypes $type
     *
     * @return JsonResponse
     */
    public function index(
            Company $company,
            System $system,
            SystemDomain $domain,
            SystemUsageStatisticTypes $type
        ): JsonResponse {
        return Response::create()
            ->addData(SystemDomainChart::create($domain, $type))
            ->toJson();
    }
}
