<?php

namespace App\Company\System\Template\Controllers;

use App\Company\System\Template\Resources\SystemTemplateListResource;
use Domain\System\Models\SystemTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Support\Client\Response;
use Support\Enums\System\SystemTemplateType;

class SystemTemplateListController
{
    /**
     * @param SystemTemplateType $type
     *
     * @return JsonResponse
     */
    public function index(SystemTemplateType $type): JsonResponse
    {
        $query = SystemTemplate::whereType($type);

        if (!Auth::user()->isSuperAdmin()) {
            $query->whereIsPublic(true);
        }

        return Response::create()
            ->addData(SystemTemplateListResource::collection($query->get()))
            ->toJson();
    }
}
