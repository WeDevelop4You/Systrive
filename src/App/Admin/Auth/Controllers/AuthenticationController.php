<?php

    namespace App\Admin\Auth\Controllers;

    use App\Admin\Auth\Requests\LoginRequest;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
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

                Response::create()
                    ->addPopup(new SimpleNotification(trans('response.success.login')))
                    ->toSession();

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

            Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.logout')))
                ->toSession();

            return $request->expectsJson()
                ? Response::create()->addRedirect(route('admin.web.login'))->toJson()
                : view('admin::pages.auth.login');
        }
    }
