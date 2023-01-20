<?php

namespace App\Account\User\Controllers;

use App\Account\User\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Support\Client\Response;

class UserController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = new Response();
        $response->addData(UserResource::make(Auth::user()));

        return $response->toJson();
    }
}
