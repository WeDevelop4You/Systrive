<?php

namespace App\Admin\Company\System\DNS\Controllers;

use App\Admin\Company\System\DNS\ListDetailers\DNSListDetail;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDNS;
use Support\Enums\VestaCommands;
use Support\Helpers\Response\Response;
use Support\Helpers\Vesta\VestaAPIHelper;

class CompanyDNSController
{
    public function index(Company $company, System $system, SystemDNS $dns)
    {
        $configData = VestaAPIHelper::create()
            ->getCommand(VestaCommands::GET_USER_DNS_DOMAIN, $system->username, $dns->name)
            ->first();

        $dns->listDetails = DNSListDetail::create($configData, $dns);
        $dns->records = VestaAPIHelper::create()
            ->getCommand(VestaCommands::GET_USER_DNS_RECORDS, $system->username, $dns->name)
            ->toArray();

        Response::create()
            ->addData()
            ->toJson();
    }
}
