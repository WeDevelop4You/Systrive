<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserRolesResource;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class UserPermissionsController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return Response::create()
                ->addData(UserRolesResource::make(Auth::user()))
                ->toJson();
        }
    }
