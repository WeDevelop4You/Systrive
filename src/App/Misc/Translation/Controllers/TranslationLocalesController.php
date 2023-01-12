<?php

namespace App\Misc\Translation\Controllers;

use Illuminate\Http\JsonResponse;
use Support\Client\Response;

class TranslationLocalesController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Response::create()
            ->addData(config('translation.locales'))
            ->toJson();
    }
}
