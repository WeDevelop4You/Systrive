<?php

    namespace App\Admin\User\Controllers;

    use Domain\User\Models\User;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class UserDestroyForceController
    {
        /**
         * @param User $user
         *
         * @return JsonResponse
         */
        public function action(User $user): JsonResponse
        {
            $user->forceDelete();

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.deleted')))
                ->toJson();
        }
    }
