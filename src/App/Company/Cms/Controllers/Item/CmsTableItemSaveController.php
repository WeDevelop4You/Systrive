<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\Requests\CmsTableItemRequest;
use Domain\Cms\Actions\CmsTableItemFileAction;
use Domain\Cms\Exceptions\CmsTableItemException;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Exceptions\Custom\TooManyFilesException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Throwable;

class CmsTableItemSaveController
{
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

        $model = CmsModel::latest()->firstOrNew()->fill($request->validated());

        try {
            $files = (new CmsTableItemFileAction($request, $table, $model))();
        } catch (CmsTableItemException) {
            return Response::create()->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.sync.saved')),
                ResponseCode::HTTP_BAD_REQUEST
            )->toJson();
        } catch (TooManyFilesException) {
            return $error;
        }

        if ($model->isDirty() || $files->isDirty()) {
            $newModel = $model->replicate();

            $success = $newModel->save();

            if (!$success) {
                return $error;
            }

            $files->save($newModel, true);

            if (CmsModel::count() > 10) {
                CmsModel::oldest()->first()->delete();
            }
        }

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
        )->addAction(
            VuexAction::create()->dispatch(
                'cms/table/overview/component',
                route('company.cms.table.search', [
                    $company->id,
                    $cms->id,
                    $table->name,
                ])
            )
        )->toJson();
    }
}
