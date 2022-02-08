<?php

    namespace App\Admin\User\Controllers;

    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class UserDestroyController
    {
        /**
         * @param User $user
         *
         * @return JsonResponse
         */
        public function action(User $user): JsonResponse
        {
            $user->delete();

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.deleted')))
                ->toJson();
        }
    }
