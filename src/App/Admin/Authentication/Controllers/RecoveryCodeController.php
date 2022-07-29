<?php

namespace App\Admin\Authentication\Controllers;

use App\Admin\Authentication\Responses\RecoveryCodeResponse;
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
