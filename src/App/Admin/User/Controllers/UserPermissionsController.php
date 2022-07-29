<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserRoleResource;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Response\Response;

    class UserPermissionsController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return Response::create()
                ->addData(UserRoleResource::make(Auth::user()))
                ->toJson();
        }
    }
