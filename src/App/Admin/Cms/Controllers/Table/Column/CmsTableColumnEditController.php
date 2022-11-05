<?php

namespace App\Admin\Cms\Controllers\Table\Column;

use App\Admin\Cms\Responses\Table\Column\CmsTableColumnEditResponse;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CmsTableColumnEditController
{
    /**
     * @param Request $request
     * @param Company $company
     * @param Cms     $cms
     * @param string  $key
     *
     * @return JsonResponse
     */
    public function index(Request $request, Company $company, Cms $cms, string $key): JsonResponse
    {
        return CmsTableColumnEditResponse::create(
            $company,
            $cms,
            $key,
            $request->query('isEditing', false)
        )->toJson();
    }
}
