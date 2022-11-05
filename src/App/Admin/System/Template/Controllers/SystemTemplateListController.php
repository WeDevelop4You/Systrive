<?php

namespace App\Admin\System\Template\Controllers;

use App\Admin\System\Template\Resources\SystemTemplateListResource;
use Domain\System\Models\SystemTemplate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Support\Enums\System\SystemTemplateType;
use Support\Response\Response;

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
