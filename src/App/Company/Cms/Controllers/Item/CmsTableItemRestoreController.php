<?php

namespace App\Company\Cms\Controllers\Item;

use App\Company\Cms\Responses\Item\CmsTableItemRestoreResponse;
use Domain\Cms\Actions\CmsTableItemRestoreAction;
use Domain\Cms\Exceptions\CmsTableItemException;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsModel;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Sentry;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Throwable;

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
        try {
            (new CmsTableItemRestoreAction())($item);
        } catch (CmsTableItemException|Throwable $e) {
            Sentry::captureException($e);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(
                    trans('response.error.restored')
                ))->toJson();
        }

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans('response.success.restored'))
        )->addAction(
            ChainAction::create()->setActions([
                VuexAction::create()->closeAllModals(),
                VuexAction::create()->dispatch(
                    'cms/table/overview/component',
                    route('company.cms.table.search', [
                        $company->id,
                        $cms->id,
                        $table->name,
                    ])
                ),
            ])
        )->toJson();
    }
}
