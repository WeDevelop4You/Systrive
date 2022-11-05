<?php

namespace App\Admin\Cms\Controllers\Table\Column;

use App\Admin\Cms\Resources\CmsTableColumnResource;
use Domain\Cms\Mappings\CmsColumnTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Cms\Seeders\ColumnSeeder;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Response;

class CmsTableColumnListController
{
    public function index(Company $company, Cms $cms, ?CmsTable $table = null): JsonResponse
    {
        $items = \is_null($table)
            ? ColumnSeeder::create()
            : $table->columns()
                ->orderBy(CmsColumnTableMap::AFTER)
                ->get();

        return Response::create()
            ->addData(CmsTableColumnResource::collection($items))
            ->toJson();
    }
}
