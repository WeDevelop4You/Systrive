<?php

namespace App\Admin\Cms\Controllers\Table\Column;

use App\Admin\Cms\Responses\Table\Column\CmsTableColumnDestroyResponse;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class CmsTableColumnDestroyController
{
    /**
     * @param Company $company
     * @param Cms     $cms
     * @param string  $key
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, string $key): JsonResponse
    {
        return CmsTableColumnDestroyResponse::create($key)->toJson();
    }
}
