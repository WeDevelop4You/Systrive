<?php

namespace App\Admin\Cms\Controllers\Table\Item;

use App\Admin\Cms\Requests\CmsTableItemRequest;
use App\Admin\Cms\Responses\Table\Item\CmsTableItemEditResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableItemEditController
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
        return CmsTableItemEditResponse::create($company, $cms, $table, $item)->toJson();
    }

    /**
     * @param CmsTableItemRequest $request
     * @param Company             $company
     * @param Cms                 $cms
     * @param CmsTable            $table
     * @param CmsModel            $item
     *
     * @return JsonResponse
     */
    public function action(CmsTableItemRequest $request, Company $company, Cms $cms, CmsTable $table, CmsModel $item): JsonResponse
    {
        $item->fill($request->validated());

        if ($item->save()) {
            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
                )
                ->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.saved')),
                ResponseCode::HTTP_BAD_REQUEST
            )
            ->toJson();
    }
}
