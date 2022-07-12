<?php

    namespace App\Admin\Authentication\Controllers;

    use App\Admin\Authentication\Requests\LoginRequest;
    use App\Admin\Authentication\Responses\OneTimePasswordResponse;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use Support\Exceptions\RequiredOneTimePasswordException;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

use function view;

    class LoginController
    {
        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index(): View|Factory|Application
        {
            return \view('admin::pages.login');
        }

        /**
         * @param LoginRequest $request
         *
         * @return JsonResponse
         */
        public function action(LoginRequest $request): JsonResponse
        {
            $response = Response::create();

            try {
                $request->authenticate();

                Response::create()
                    ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.login')))
                    ->toSession();

                $response->addRedirect(route('admin.dashboard'));
            } catch (ValidationException $e) {
                $response->addErrors($e->errors());
            } catch (RequiredOneTimePasswordException) {
                $response = OneTimePasswordResponse::create()
                    ->setStatusCode(ResponseCodes::HTTP_UNPROCESSABLE_ENTITY);
            }

            return $response->toJson();
        }
    }
