<?php

    namespace App\Admin\User\Controllers;

    use App\Controller;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;

    class UserDestroyForceController extends Controller
    {
        /**
         * @param User $user
         *
         * @return JsonResponse
         */
        public function action(User $user): JsonResponse
        {
            $user->forceDelete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.force.account'));

            return $response->toJson();
        }
    }
