<?php

namespace App\Account\Settings\Controllers;

use App\Account\Settings\Responses\SettingsNavigationResponse;
use Illuminate\Http\JsonResponse;

class SettingsNavigationController
{
    public function index(): JsonResponse
    {
        return SettingsNavigationResponse::create()->toJson();
    }
}
