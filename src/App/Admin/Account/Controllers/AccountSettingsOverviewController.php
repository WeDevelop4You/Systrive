<?php

namespace App\Admin\Account\Controllers;

use App\Admin\Account\Responses\AccountSettingsOverviewResponse;
use Illuminate\Http\JsonResponse;

class AccountSettingsOverviewController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return AccountSettingsOverviewResponse::create()->toJson();
    }
}
