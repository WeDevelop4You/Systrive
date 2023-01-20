<?php

namespace App\Company\Cms\Controllers\Column;

use App\Company\Cms\DataTables\CmsTableColumnTable;
use App\Company\Cms\Requests\CmsTableColumnRequest;
use App\Company\Cms\Resources\CmsTableColumnResource;
use App\Company\Cms\Responses\Column\CmsTableColumnCreateResponse;
use Domain\Cms\Mappings\CmsTableTableMap;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Support\Client\DataTable\Build\Rows;
use Support\Client\Response;

class CmsTableColumnCreateController
{
    /**
     * @param Request $request
     * @param Company $company
     * @param Cms     $cms
     *
     * @return JsonResponse
     */
    public function index(Request $request, Company $company, Cms $cms): JsonResponse
    {
        return CmsTableColumnCreateResponse::create(
            $company,
            $cms,
            $request->query('isEditing', false)
        )->toJson();
    }

    /**
     * @param CmsTableColumnRequest $request
     * @param Company               $company
     * @param Cms                   $cms
     *
     * @return JsonResponse
     */
    public function action(CmsTableColumnRequest $request, Company $company, Cms $cms): JsonResponse
    {
        $column = new CmsColumn($request->validated());
        $column->deletable = ! \in_array($column->key, CmsTableTableMap::REQUIRED_COLUMNS);

        $items = Rows::create(
            Collection::make([$column]),
            CmsTableColumnTable::create($company, $cms)->getColumns(),
            $request
        );

        return Response::create()
            ->addData([
                'tableItem' => Arr::first($items),
                'listItem' => CmsTableColumnResource::make($column),
            ])->toJson();
    }
}
