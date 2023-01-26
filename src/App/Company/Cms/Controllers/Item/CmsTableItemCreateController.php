<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\Requests\CmsTableItemRequest;
use App\Company\Cms\Responses\Item\CmsTableItemCreateResponse;
use Domain\Cms\Actions\CmsTableItemFileAction;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Throwable;

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
     *
     * @throws Throwable
     */
    public function action(CmsTableItemRequest $request, Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        $error = Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.error.saved')),
            ResponseCode::HTTP_BAD_REQUEST
        )->toJson();

        $model = new CmsModel($request->validated());

        try {
            $files = (new CmsTableItemFileAction($request, $table, $model))();
        } catch (\Exception) {
            return $error;
        }

        if ($model->save()) {
            $files->save($model);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
                )->toJson();
        }

        return $error;
    }
}
