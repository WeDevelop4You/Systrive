<?php

    namespace App\Admin\Translation\Controllers;

    use Domain\User\Actions\EditLocaleAction;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class LocaleController
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
                (new EditLocaleAction())($locale);

                $response->addData([
                    'locale' => $locale,
                ]);
            } else {
                $response->addPopup(new SimpleNotification(trans('response.error.locale')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            return $response->toJson();
        }
    }
