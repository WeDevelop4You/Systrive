<?php

    namespace App\Account\User\Controllers;

    use Domain\User\Actions\UpdateUserLocaleAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Response as HttpResponse;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Client\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

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
         * @return HttpResponse|JsonResponse
         */
        public function action(string $locale): HttpResponse|JsonResponse
        {
            $response = Response::create();

            if (\in_array($locale, config('translation.locales'))) {
                (new UpdateUserLocaleAction())($locale);
            } else {
                $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.locale')))
                    ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
            }

            return $response->toJson();
        }
    }
