<?php

namespace App\Admin\Translation\Controllers;

use Illuminate\Http\JsonResponse;
use Support\Response\Response;

class LocaleController
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
