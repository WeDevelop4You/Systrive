<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\Requests\CmsTableItemRequest;
use App\Company\Cms\Responses\Item\CmsTableItemEditResponse;
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
     *
     * @throws Throwable
     */
    public function action(CmsTableItemRequest $request, Company $company, Cms $cms, CmsTable $table, CmsModel $item): JsonResponse
    {
        $error = Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.error.saved')),
            ResponseCode::HTTP_BAD_REQUEST
        )->toJson();

        $item->fill($request->validated());

        try {
            $files = (new CmsTableItemFileAction($request, $table, $item))();
        } catch (\Exception) {
            return $error;
        }

        if ($item->isDirty()) {
            if (!$item->save()) {
                return $error;
            }
        }

        if ($files->isDirty()) {
            $files->save($item);
        }

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
        )->toJson();
    }
}
