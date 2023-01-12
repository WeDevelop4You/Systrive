<?php

namespace App\Company\Cms\Controllers;

use App\Company\Cms\Responses\CmsTableOverviewResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class CmsTableOverviewController
{
    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        return CmsTableOverviewResponse::create($company, $cms, $table)->toJson();
    }
}
