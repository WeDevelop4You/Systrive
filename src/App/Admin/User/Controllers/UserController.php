<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Resources\UserResource;
    use App\Controller;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Response;

    class UserController extends Controller
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $response = new Response();
            $response->addData(Auth::user(), UserResource::class);

            return $response->toJson();
        }
    }
