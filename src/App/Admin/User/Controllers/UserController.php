<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserResource;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

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
