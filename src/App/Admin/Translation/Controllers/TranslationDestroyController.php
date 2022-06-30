<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\Responses\TranslationDestroyResponse;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationDestroyController
    {
        /**
         * @param TranslationKey $translationKey
         *
         * @return JsonResponse
         */
        public function index(TranslationKey $translationKey): JsonResponse
        {
            return TranslationDestroyResponse::create($translationKey)->toJson();
        }

        /**
         * @param TranslationKey $translationKey
         *
         * @return JsonResponse
         */
        public function action(TranslationKey $translationKey): JsonResponse
        {
            $translationKey->delete();

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.deleted')))
                ->toJson();
        }
    }
