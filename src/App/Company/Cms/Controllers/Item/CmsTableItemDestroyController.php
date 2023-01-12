<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\Responses\Item\CmsTableItemDestroyResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class CmsTableItemDestroyController
{
    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     * @param CmsModel $item
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, CmsTable $table, CmsModel $item): JsonResponse
    {
        return CmsTableItemDestroyResponse::create($company, $cms, $table, $item)->toJson();
    }

    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     * @param CmsModel $item
     *
     * @return JsonResponse
     */
    public function action(Company $company, Cms $cms, CmsTable $table, CmsModel $item): JsonResponse
    {
        if ($item->delete()) {
            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.deleted'))
                )->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.deleted'))
            )->toJson();
    }
}
