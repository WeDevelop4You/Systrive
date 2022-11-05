<?php

namespace App\Admin\Cms\Controllers\Table\Item;

use App\Admin\Cms\Requests\CmsTableItemRequest;
use App\Admin\Cms\Responses\Table\Item\CmsTableItemCreateResponse;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableItemCreateController
{
    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        return CmsTableItemCreateResponse::create($company, $cms, $table)->toJson();
    }

    /**
     * @param CmsTableItemRequest $request
     * @param Company             $company
     * @param Cms                 $cms
     * @param CmsTable            $table
     *
     * @return JsonResponse
     */
    public function action(CmsTableItemRequest $request, Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        $model = new CmsModel($request->validated());

        if ($model->save()) {
            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
                )->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.saved')),
                ResponseCode::HTTP_BAD_REQUEST
            )->toJson();
    }
}
