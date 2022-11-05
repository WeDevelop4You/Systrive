<?php

namespace App\Admin\Cms\Controllers\Table;

use App\Admin\Cms\Responses\Table\CmsTableOverviewResponse;
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
