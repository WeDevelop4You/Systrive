<?php

    namespace App\Admin\Account\Controllers;

    use App\Admin\Account\Requests\ChangePasswordRequest;
    use Domain\User\Actions\UpdatePasswordAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use function trans;

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

            (new UpdatePasswordAction(Auth::user()))($password);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.saved')))
                ->toJson();
        }
    }
