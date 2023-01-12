<?php

namespace App\Company\Cms\Controllers;

use App\Company\Cms\Responses\CmsTableDestroyResponse;
use Domain\Cms\Actions\CmsTableDestroyAction;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\RouteAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
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
                        RouteAction::create()->goTo(VueRouteHelper::createCompany($company)),
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
