<?php

    namespace App\Admin\Translation\Controllers;

    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Response;
    use WeDevelop4You\TranslationFinder\Classes\Manager;
    use WeDevelop4You\TranslationFinder\Exceptions\FailedToBuildTranslationFileException;

    class TranslationPublishController
    {
        /**
         * @return JsonResponse
         *
         * @throws FailedToBuildTranslationFileException
         */
        public function action(): JsonResponse
        {
            Manager::publishAll();

            $response = new Response();
            $response->addPopup(trans('response.success.publish.translations'));

            return $response->toJson();
        }
    }
