<?php

namespace App\Company\Cms\Controllers\Item\file;

use App\Company\Cms\Requests\CmsTableItemFileRequest;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;

class CmsTableItemFileUploader
{
    public function action(CmsTableItemFileRequest $request, Company $company, Cms $cms, CmsTable $table): JsonResponse
    {

    }
}
