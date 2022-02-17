<?php

    namespace App\Admin\Authentication\Controllers;

    use App\Admin\Authentication\Requests\LoginRequest;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Validation\ValidationException;
    use function route;
    use Support\Enums\FormTypes;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Enums\Vuetify\VuetifyColors;
    use Support\Enums\Vuetify\VuetifySizeTypes;
    use Support\Exceptions\RequiredOneTimePasswordException;
    use Support\Helpers\Response\Action\Methods\RequestMethods;
    use Support\Helpers\Response\Action\Methods\VuexMethods;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\FormModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;
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
                        ->setDismissible()
                        ->setTitle(trans('modal.verify.title'))
                        ->setFormComponent(FormTypes::ONE_TIME_PASSWORD)
                        ->setCloseAction(
                            VuexMethods::create()->commit('guest/setOneTimePassword', '')
                        )
                        ->addButton(
                            Button::create()
                                ->setColor()
                                ->setTitle(trans('modal.verify.verify'))
                                ->setType(VuetifyButtonTypes::BLOCK)
                                ->setAction(
                                    VuexMethods::create()->dispatch('guest/login', 'OTP')
                                )->setListener()
                        )->addButton(
                            Button::create()
                                ->setType()
                                ->setTitle(trans('modal.use.recovery.code'))
                                ->setType(VuetifyButtonTypes::BLOCK)
                                ->setSize(VuetifySizeTypes::X_SMALL)
                                ->setColor(VuetifyColors::TRANSPARENT)
                                ->setAction(
                                    RequestMethods::create()->get(route('admin.recovery.code'))
                                )
                        )->setMaxWidth(323)
                )->setStatusCode(ResponseCodes::HTTP_UNPROCESSABLE_ENTITY);
            }

            return $response->toJson();
        }
    }
