<?php

namespace App\Admin\System\Database\Controllers;

use App\Admin\System\Database\Responses\SystemDatabaseOverviewResponse;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Support\Enums\VestaCommands;
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
            ->get(VestaCommands::GET_USER_DATABASE, $system->username, $database->name)
            ->first();

        return SystemDatabaseOverviewResponse::create($company, $database, Collection::make($configData))->toJson();
    }
}
