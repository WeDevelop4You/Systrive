<?php

namespace App\Account\Settings\Controllers;

use App\Account\Settings\Responses\SettingsOverviewResponse;
use Illuminate\Http\JsonResponse;

class SettingsOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return SettingsOverviewResponse::create()->toJson();
    }
}
