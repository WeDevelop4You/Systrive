<?php

    namespace App\Admin\Authentication\Controllers;

    use App\Admin\Authentication\Requests\LoginRequest;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use Support\Enums\FormTypes;
    use Support\Enums\RequestMethodTypes;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Exceptions\RequiredOneTimePasswordException;
    use Support\Helpers\Response\Action\Methods\VuexMethods;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\FormModal;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;
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
            } catch (RequiredOneTimePasswordException) {
                $response->addPopup(
                    FormModal::create()
                        ->setTitle(trans('modal.2fa.title'))
                        ->setFormComponent(FormTypes::ONE_TIME_PASSWORD)
                        ->addButton(
                            Button::create()
                                ->setTitle(trans('modal.cancel.cancel'))
                                ->setType(VuetifyButtonTypes::TEXT)
                                ->setAction(
                                    VuexMethods::create()
                                        ->commit('guest/setOneTimePassword', '')
                                )
                        )->addButton(
                            Button::create()
                                ->setTitle(trans('modal.verify.verify'))
                                ->setColor()
                                ->setAction(
                                    VuexMethods::create()
                                        ->dispatch('guest/login', true)
                                )->setListener()
                        )->setMaxWidth(323)
                )->setStatusCode(ResponseCodes::HTTP_UNPROCESSABLE_ENTITY);
            }

            return $response->toJson();
        }
    }
