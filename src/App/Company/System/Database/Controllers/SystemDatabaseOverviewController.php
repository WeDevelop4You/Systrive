<?php

namespace App\Company\System\Database\Controllers;

use App\Company\System\Database\Responses\SystemDatabaseOverviewResponse;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Support\Enums\VestaCommand;
use Support\Services\Vesta;

class SystemDatabaseOverviewController
{
    /**
     * @param Company        $company
     * @param System         $system
     * @param SystemDatabase $database
     *
     * @return JsonResponse
     */
    public function index(Company $company, System $system, SystemDatabase $database): JsonResponse
    {
        $configData = Vesta::api()
            ->get(VestaCommand::GET_USER_DATABASE, $system->username, $database->name)
            ->first();

        return SystemDatabaseOverviewResponse::create($company, $database, Collection::make($configData))->toJson();
    }
}
