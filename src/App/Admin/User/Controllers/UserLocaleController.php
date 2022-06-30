<?php

    namespace App\Admin\User\Controllers;

    use Domain\User\Actions\UpdateUserLocaleAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class UserLocaleController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            $locale = Auth::check()
                ? Auth::user()->locale
                : Session::get('locale', App::getFallbackLocale());

            return Response::create()->addData([
                'locale' => $locale,
            ])->toJson();
        }

        /**
         * @param string $locale
         *
         * @return JsonResponse
         */
        public function action(string $locale): JsonResponse
        {
            $response = new Response();

            if (in_array($locale, config('translation.locales'))) {
                (new UpdateUserLocaleAction())($locale);
            } else {
                $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.locale')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            return $response->toJson();
        }
    }
