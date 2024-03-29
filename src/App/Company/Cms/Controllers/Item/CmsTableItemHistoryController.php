<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\Responses\Item\CmsTableItemHistoryResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class CmsTableItemHistoryController
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
        return CmsTableItemHistoryResponse::create($company, $cms, $table)->toJson();
    }
}
