<?php

namespace App\Admin\System\Database\Controllers;

use App\Admin\System\Database\ListDetails\DatabaseListDetail;
use App\Admin\System\Database\Resources\CompanyDatabaseResource;
use Domain\Company\Models\Company;
use Domain\System\Models\System;
use Domain\System\Models\SystemDatabase;
use Illuminate\Http\JsonResponse;
use Support\Enums\VestaCommands;
use Support\Helpers\Response\Response;
use Support\Helpers\Vesta\VestaAPIHelper;

class CompanyDatabaseController
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
        $configData = VestaAPIHelper::create()
            ->getCommand(VestaCommands::GET_USER_DATABASE, $system->username, $database->name)
            ->first();

        $database->listDetails = DatabaseListDetail::create($configData, $database);

        return Response::create()
            ->addData(CompanyDatabaseResource::make($database))
            ->toJson();
    }
}
