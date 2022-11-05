<?php

namespace App\Admin\Cms\Controllers\Table\Column;

use App\Admin\Cms\DataTables\CmsTableColumnTable;
use App\Admin\Cms\Requests\CmsTableColumnRequest;
use App\Admin\Cms\Resources\CmsTableColumnResource;
use App\Admin\Cms\Responses\Table\Column\CmsTableColumnCreateResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Support\Helpers\DataTable\Build\Rows;
use Support\Response\Response;

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
            $company, $cms, $request->query('isEditing', false)
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
        $column->deletable = true;

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
