<?php

namespace App\Admin\Cms\Controllers\Table;

use App\Admin\Cms\Responses\Table\CmsTableDestroyResponse;
use Domain\Cms\Actions\CmsTableDestroyAction;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\RouteAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableDestroyController
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
        return CmsTableDestroyResponse::create($company, $cms, $table)->toJson();
    }

    /**
     * @param Company  $company
     * @param Cms      $cms
     * @param CmsTable $table
     *
     * @return JsonResponse
     */
    public function action(Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        $successFull = (new CmsTableDestroyAction())($table);

        if ($successFull) {
            return Response::create()
                ->addAction(
                    ChainAction::create()->setActions([
                        VuexAction::create()->dispatch('navigation/company', $company->id),
                        RouteAction::create()->goToCompany($company)
                    ])
                )
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.deleted'))
                )
                ->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.deleted')),
                ResponseCode::HTTP_BAD_REQUEST
            )
            ->toJson();
    }
}
