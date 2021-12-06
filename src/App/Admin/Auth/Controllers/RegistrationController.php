<?php

    namespace App\Admin\Auth\Controllers;

    use App\Admin\Auth\Requests\RegistrationRequest;
    use Domain\User\Actions\EditPasswordAction;
    use Domain\User\Actions\RegisterUserAction;
    use Domain\User\Actions\ValidateInviteTokenAction;
    use Domain\User\DataTransferObjects\UserProfileData;
    use Domain\User\Models\User;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Session;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class RegistrationController
    {
        /**
         * @return Application|Factory|View|RedirectResponse
         */
        public function index(): View|Factory|RedirectResponse|Application
        {
            if (Session::has(Response::SESSION_KEY_REGISTRATION)) {
                try {
                    $userInvite = (new ValidateInviteTokenAction(...Session::get(Response::SESSION_KEY_REGISTRATION)))();

                    return view('admin::pages.auth.registration')->with('email', $userInvite->email);
                } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                    Session::put(Response::SESSION_KEY_DEFAULT, Response::create()
                        ->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                        ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                        ->createResponseContent()
                    );
                }
            }

            return redirect()->route('admin.web.login');
        }

        /**
         * @param RegistrationRequest $request
         *
         * @return JsonResponse
         */
        public function action(RegistrationRequest $request): JsonResponse
        {
            $response = new Response();

            if (Session::has(Response::SESSION_KEY_REGISTRATION)) {
                $data = new UserProfileData(...$request->only([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'gender',
                    'birth_date',
                ]));

                try {
                    (new RegisterUserAction($request->get('password')))($data);

                    Session::put(Response::SESSION_KEY_DEFAULT, Response::create()
                        ->addPopup(new SimpleNotification(trans('response.success.registered.and.accepted')))
                        ->createResponseContent()
                    );

                    return $response->addRedirect(route('admin.dashboard'))->toJson();
                } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                    //
                }
            }

            return $response->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                ->toJson();
        }
    }
