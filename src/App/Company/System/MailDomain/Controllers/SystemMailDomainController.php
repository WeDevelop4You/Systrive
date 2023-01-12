<?php

namespace App\Company\System\MailDomain\Controllers;

use App\Company\System\MailDomain\Responses\SystemMailDomainOverviewResponse;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemMailDomain;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;

class SystemMailDomainController
{
    /**
     * @param Company          $company
     * @param System           $system
     * @param SystemMailDomain $mailDomain
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemMailDomain $mailDomain): JsonResponse
    {
        $configData = Vesta::api()
            ->get(VestaCommand::GET_USER_MAIL_DOMAIN, $system->username, $mailDomain->name)
            ->first();

        return SystemMailDomainOverviewResponse::create(
            $company,
            $mailDomain,
            Collection::make($configData)
        )->toJson();
    }
}
