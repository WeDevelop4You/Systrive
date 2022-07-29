<?php

    namespace App\Admin\User\Controllers;

    use App\Admin\User\Responses\UserDestroyResponse;
    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class UserDestroyController
    {
        /**
         * @param User $user
         *
         * @return JsonResponse
         */
        public function index(User $user): JsonResponse
        {
            return UserDestroyResponse::create($user)->toJson();
        }

        /**
         * @param User $user
         *
         * @return JsonResponse
         */
        public function action(User $user): JsonResponse
        {
            $user->delete();

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.deleted')))
                ->toJson();
        }
    }
