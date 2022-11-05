<?php

namespace App\Admin\Cms\Controllers;

use App\Admin\Cms\Resources\CmsListResource;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Response;

class CmsListController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return Response::create()
            ->addData(CmsListResource::collection(
                Cms::whereCompanyId($company->id)->get()->unique(function (Cms $cms) {
                    return $cms->username->decryptString();
                })->sortBy(function (Cms $cms) {
                    return $cms->username->decryptString();
                })
            ))
            ->toJson();
    }
}
