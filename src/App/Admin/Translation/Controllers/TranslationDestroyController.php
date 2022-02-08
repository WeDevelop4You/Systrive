<?php

    namespace App\Admin\Translation\Controllers;

    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationDestroyController
    {
        /**
         * @param TranslationKey $translationKey
         *
         * @return JsonResponse
         */
        public function action(TranslationKey $translationKey): JsonResponse
        {
            $translationKey->delete();

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.deleted')))
                ->toJson();
        }
    }
