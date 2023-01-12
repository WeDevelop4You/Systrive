<?php

namespace App\Company\System\Dns\Controllers;

use App\Company\System\Dns\Responses\SystemDNSOverviewResponse;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;

class SystemDNSOverviewController
{
    /**
     * @param Company   $company
     * @param System    $system
     * @param SystemDNS $dns
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemDNS $dns): JsonResponse
    {
        $configData = Vesta::api()
            ->get(VestaCommand::GET_USER_DNS_DOMAIN, $system->username, $dns->name)
            ->first();

        return SystemDNSOverviewResponse::create($company, $dns, Collection::make($configData))->toJson();
    }
}
