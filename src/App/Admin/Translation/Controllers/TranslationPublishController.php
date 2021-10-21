<?php

    namespace App\Admin\Translation\Controllers;

    use App\Admin\Translation\Requests\TranslationUpdateRequests;
    use App\Admin\Translation\Resources\TranslationKeyDataResource;
    use App\Admin\Translation\Resources\TranslationKeyResource;
    use App\Controller;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
    use Illuminate\Support\Collection;
    use Support\Helpers\Response\Response;
    use Support\Helpers\Table\Build\Column;
    use Support\Helpers\Table\Build\DataTable;
    use WeDevelop4You\TranslationFinder\Classes\Manager;
    use WeDevelop4You\TranslationFinder\Exceptions\FailedToBuildTranslationFileException;
    use WeDevelop4You\TranslationFinder\Models\Translation;
    use WeDevelop4You\TranslationFinder\Models\TranslationKey;

    class TranslationPublishController extends Controller
    {
        /**
         * @return JsonResponse
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
