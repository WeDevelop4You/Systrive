<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserListResource;

    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class UserListController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return Response::create()
                ->addData(UserListResource::collection(
                    User::withTrashed()->with('profile')->orderBy(UserTableMap::EMAIL)->get()
                ))->toJson();
        }
    }
