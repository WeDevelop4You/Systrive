<?php

namespace App\Admin\Cms\Controllers;

use App\Admin\Cms\Resources\CmsResource;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Response;

class CmsSearchController
{
    /**
     * @param Company $company
     * @param Cms     $cms
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms): JsonResponse
    {
        return Response::create()
            ->addData(CmsResource::make($cms))
            ->toJson();
    }
}
