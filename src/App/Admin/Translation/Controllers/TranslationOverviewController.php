<?php

namespace App\Admin\Translation\Controllers;

use App\Admin\Translation\Responses\TranslationOverviewResponse;
use Illuminate\Http\JsonResponse;

class TranslationOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return TranslationOverviewResponse::create()->toJson();
    }
}
