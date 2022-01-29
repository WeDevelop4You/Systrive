<?php

    namespace App\Admin\Authentication\Controllers;

    use App\Admin\Authentication\Requests\LoginRequest;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use function route;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use function trans;
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
            return view('admin::pages.login');
        }

        /**
         * @param LoginRequest $request
         *
         * @return JsonResponse
         */
        public function action(LoginRequest $request): JsonResponse
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
    }
