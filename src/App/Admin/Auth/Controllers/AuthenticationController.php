<?php

    namespace App\Admin\Auth\Controllers;

    use App\Admin\Auth\Requests\LoginRequest;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Validation\ValidationException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class AuthenticationController
    {
        /**
         * Display a listing of the resource.
         *
         * @return Application|Factory|View
         */
        public function index(): View|Factory|Application
        {
            return view('admin::pages.auth.login');
        }

        /**
         * @param LoginRequest $request
         *
         * @return JsonResponse
         */
        public function login(LoginRequest $request): JsonResponse
        {
            $response = new Response();

            try {
                $request->authenticate();

                Session::put(
                    Response::SESSION_KEY_DEFAULT,
                    Response::create()
                        ->addPopup(new SimpleNotification(trans('response.success.login')))
                        ->createResponseContent()
                );

                $response->addRedirect(route('admin.dashboard'));
            } catch (ValidationException $e) {
                $response->addErrors($e->errors());
            }

            return $response->toJson();
        }

        /**
         * @param Request $request
         *
         * @return Application|Factory|JsonResponse|View
         */
        public function logout(Request $request): View|Factory|JsonResponse|Application
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            Session::put(
                Response::SESSION_KEY_DEFAULT,
                Response::create()
                    ->addPopup(new SimpleNotification(trans('response.success.logout')))
                    ->createResponseContent()
            );

            return $request->expectsJson()
                ? Response::create()->addRedirect(route('admin.web.login'))->toJson()
                : view('admin::pages.auth.login');
        }
    }
