<?php

namespace App\Company\Cms\Controllers\Column;

use App\Company\Cms\Resources\CmsTableColumnResource;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Seeders\ColumnSeeder;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Response;

class CmsTableColumnListController
{
    public function index(Company $company, Cms $cms, ?CmsTable $table = null): JsonResponse
    {
        $items = \is_null($table) ? ColumnSeeder::create() : $table->columns()->sorted()->get();

        return Response::create()
            ->addData(CmsTableColumnResource::collection($items))
            ->toJson();
    }
}
