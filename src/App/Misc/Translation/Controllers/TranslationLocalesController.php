<?php

namespace App\Misc\Translation\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Support\Client\Response;

class TranslationLocalesController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $locales = Arr::map(
            Config::get('translation.locales', []),
            function (string $name, string $identifier) {
                return ['name' => $name, 'identifier' => $identifier];
            }
        );

        return Response::create()
            ->addData($locales)
            ->toJson();
    }
}
