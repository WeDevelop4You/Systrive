<?php

namespace App\Company\Cms\Controllers;

use App\Company\Cms\Requests\CmsTableRequest;
use App\Company\Cms\Responses\CmsTableCreateResponse;
use Domain\Cms\Actions\CmsTableStoreAction;
use Domain\Cms\DataTransferObjects\CmsTableData;
use Domain\Cms\Exceptions\CmsRollbackException;
use Domain\Cms\Exceptions\CmsTableCreateException;
use Domain\Cms\Models\Cms;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Sentry;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\RouteAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableCreateController
{
    /**
     * @param Company $company
     * @param Cms     $cms
     *
     * @return JsonResponse
     */
    public function index(Company $company, Cms $cms): JsonResponse
    {
        return CmsTableCreateResponse::create($company, $cms)->toJson();
    }

    /**
     * @param CmsTableRequest $request
     * @param Company         $company
     * @param Cms             $cms
     *
     * @return JsonResponse
     */
    public function action(CmsTableRequest $request, Company $company, Cms $cms): JsonResponse
    {
        $data = new CmsTableData(...$request->validated());

        try {
            $table = (new CmsTableStoreAction())($data);
        } catch (CmsTableCreateException|CmsRollbackException $e) {
            Sentry::captureException($e);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.error.saved')),
                    ResponseCode::HTTP_BAD_REQUEST
                )->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
            )
            ->addAction(
                ChainAction::create()->setActions([
                    RouteAction::create()->goTo(
                        VueRouteHelper::create()
                            ->setName('cms.table')
                            ->setParams([
                                'cmsName' => $cms->database,
                                'tableName' => $table->name,
                            ])
                    ),
                    VuexAction::create()->dispatch(
                        'navigation/company',
                        $company->id
                    ),
                ])
            )->toJson();
    }
}
