<?php

namespace App\Admin\Account\Controllers;

use App\Admin\Account\Responses\AccountSettingsNavigationResponse;
use Illuminate\Http\JsonResponse;

class AccountSettingsNavigationController
{
    public function index(): JsonResponse
    {
        return AccountSettingsNavigationResponse::create()->toJson();
    }
}
