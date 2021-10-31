<?php

    namespace App\Admin\Translation\Controllers;

    use App\Controller;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationDestroyController extends Controller
    {
        /**
         * @param TranslationKey $translationKey
         *
         * @return JsonResponse
         */
        public function action(TranslationKey $translationKey): JsonResponse
        {
            $translationKey->delete();

            $response = new Response();
            $response->addPopup(trans('response.success.delete.translation'));

            return $response->toJson();
        }
    }
