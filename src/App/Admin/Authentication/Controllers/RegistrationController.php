<?php

    namespace App\Admin\Authentication\Controllers;

    use App\Admin\Authentication\Requests\RegistrationRequest;
    use Domain\Authentication\Actions\RegisterUserAction;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\User\DataTransferObjects\UserProfileData;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Session;
    use function redirect;
    use function route;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;
    use function trans;
    use function view;

    class RegistrationController
    {
        /**
         * @return Application|Factory|RedirectResponse|View
         */
        public function index(): View|Factory|RedirectResponse|Application
        {
            if (Session::has(Response::SESSION_KEY_REGISTRATION)) {
                try {
                    $inviteData = new InviteData(...Response::getSessionData(Response::SESSION_KEY_REGISTRATION));

                    $invite = (new ValidateInviteTokenAction())($inviteData);

                    return view('admin::pages.registration')->with('email', $invite->email);
                } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                    Response::create()
                        ->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                        ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                        ->toSession();
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

                    Response::create()
                        ->addPopup(new SimpleNotification(trans('response.success.registered.and.accepted')))
                        ->toSession();

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
