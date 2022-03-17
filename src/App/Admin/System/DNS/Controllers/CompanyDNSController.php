<?php

namespace App\Admin\System\DNS\Controllers;

use App\Admin\System\DNS\ListDetailers\DNSListDetail;
use App\Admin\System\DNS\Resources\CompanyDNSResource;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Illuminate\Http\JsonResponse;
use Support\Enums\VestaCommands;
use Support\Helpers\Response\Response;
use Support\Helpers\Vesta\VestaAPIHelper;

class CompanyDNSController
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
        $configData = VestaAPIHelper::create()
            ->getCommand(VestaCommands::GET_USER_DNS_DOMAIN, $system->username, $dns->name)
            ->first();

        $dns->listDetails = DNSListDetail::create($configData, $dns);

        return Response::create()
            ->addData(CompanyDNSResource::make($dns))
            ->toJson();
    }
}
