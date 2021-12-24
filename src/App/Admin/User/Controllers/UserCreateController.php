<?php

    namespace App\Admin\User\Controllers;

    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\User\Actions\LogoutAction;
    use Illuminate\Contracts\Encryption\EncryptException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class UserCreateController
    {
        /**
         * @param Request $request
         *
         * @return JsonResponse
         */
        public function index(Request $request): JsonResponse
        {
            Session::forget(Response::SESSION_KEY_MODAL);

            dd(Session::all());

            (new LogoutAction())($request);

            return Response::create()
                ->addRedirect(route('admin.web.login'))
                ->toJson();
        }

        public function action(Company $company, string $token, string $encryptEmail)
        {
            $response = new Response();

            try {
                (new ValidateInviteTokenAction($company, $token, $encryptEmail))();
            } catch (ModelNotFoundException | InvalidTokenException | EncryptException) {
                Session::forget(Response::SESSION_KEY_MODAL_LOGIN);

                $response->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }
        }
    }
