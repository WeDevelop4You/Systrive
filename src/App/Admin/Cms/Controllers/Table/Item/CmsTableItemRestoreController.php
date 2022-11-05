<?php

namespace App\Admin\Cms\Controllers\Table\Item;

use App\Admin\Cms\Responses\Table\Item\CmsTableItemHistoryResponse;
use App\Admin\Cms\Responses\Table\Item\CmsTableItemRestoreResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;

class CmsTableItemRestoreController
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
        return CmsTableItemRestoreResponse::create($company, $cms, $table, $item)->toJson();
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
        $item->created_at = Carbon::now();

        if ($item->save()) {
            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(
                    trans('response.error.restored')
                ))->toJson();
        }

        return Response::create()
            ->addPopup(SimpleNotificationComponent::create()->setText(
                trans('response.success.restored')
            ))->toJson();
    }
}
