<?php

    namespace App\Admin\Auth\Controllers;

    use App\Admin\Auth\Requests\PasswordRecoveryRequest;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Password;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class PasswordRecoveryController
    {
        /**
         * @return Application|Factory|View
         */
        public function index(): Factory|View|Application
        {
            return view('admin::pages.auth.password-recovery');
        }

        /**
         * @param PasswordRecoveryRequest $request
         *
         * @return JsonResponse
         */
        public function action(PasswordRecoveryRequest $request): JsonResponse
        {
            $status = Password::sendResetLink($request->only('email'));

            $response = new Response();

            if ($status === Password::RESET_LINK_SENT) {
                $response->addPopup(new SimpleNotification(trans($status)));
            } else {
                $response->addErrors('email', [trans($status)]);
            }

            return $response->toJson();
        }
    }
