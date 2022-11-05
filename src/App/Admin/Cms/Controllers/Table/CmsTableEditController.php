<?php

namespace App\Admin\Cms\Controllers\Table;

use App\Admin\Cms\Requests\CmsTableRequest;
use App\Admin\Cms\Responses\Table\CmsTableEditResponse;
use Domain\Cms\Actions\CmsTableUpdateAction;
use Domain\Cms\DataTransferObjects\CmsTableData;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Exception;
use Illuminate\Http\JsonResponse;
use Sentry;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\RouteAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsTableEditController
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
        return CmsTableEditResponse::create($company, $cms, $table)->toJson();
    }

    /**
     * @param CmsTableRequest $request
     * @param Company         $company
     * @param Cms             $cms
     * @param CmsTable        $table
     *
     * @return JsonResponse
     */
    public function action(CmsTableRequest $request, Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        $data = new CmsTableData(...$request->validated());

        try {
            $status = (new CmsTableUpdateAction($table))($data);
        } catch (Exception $e) {
            Sentry::captureException($e);

            return Response::create()
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.error.saved')),
                    ResponseCode::HTTP_BAD_REQUEST
                )->toJson();
        }

        $action = match ($status) {
            CmsTableUpdateAction::REFRESH_ALL => ChainAction::create()
                ->setActions([
                    VuexAction::create()->dispatch('navigation/company', $company->id),
                    RouteAction::create()->goTo(
                        VueRouteHelper::create()
                            ->setName('company.cms.table')
                            ->setParams(['tableName' => $table->name])
                    )
                ]),
            CmsTableUpdateAction::REFRESH_TABLE => VuexAction::create()
                ->resetTable('company/cms/table/items/dataTable')
        };

        return Response::create()
            ->addAction($action)
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.saved'))
            )->toJson();
    }
}
