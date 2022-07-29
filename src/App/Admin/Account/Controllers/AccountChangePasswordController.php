<?php

    namespace App\Admin\Account\Controllers;

    use App\Admin\Account\Requests\ChangePasswordRequest;
    use Domain\User\Actions\UpdateUserPasswordAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;

    class AccountChangePasswordController
    {
        /**
         * @param ChangePasswordRequest $request
         *
         * @return JsonResponse
         */
        public function action(ChangePasswordRequest $request): JsonResponse
        {
            $password = $request->get('password');

            (new UpdateUserPasswordAction(Auth::user()))($password);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->toJson();
        }
    }
