<?php

namespace App\Account\Authentication\Controllers;

use App\Account\Authentication\Responses\RecoveryCodeResponse;
use Illuminate\Http\JsonResponse;

class RecoveryCodeController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return RecoveryCodeResponse::create()->toJson();
    }
}
