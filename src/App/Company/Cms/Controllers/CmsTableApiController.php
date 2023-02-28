<?php

namespace App\Company\Cms\Controllers;

use App\Company\Cms\Requests\CmsTableApiRequest;
use App\Company\Cms\Responses\CmsTableApiResponse;
use Domain\Cms\DataTransferObjects\CmsTableApi;
use Domain\Cms\Models\Cms;
use Domain\Cms\Models\CmsColumn;
use Domain\Cms\Models\CmsTable;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Throwable;

class CmsTableApiController
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
        return CmsTableApiResponse::create($company, $cms, $table)->toJson();
    }

    /**
     * @param CmsTableApiRequest $request
     * @param Company            $company
     * @param Cms                $cms
     * @param CmsTable           $table
     *
     * @return JsonResponse
     *
     * @throws Throwable
     */
    public function action(CmsTableApiRequest $request, Company $company, Cms $cms, CmsTable $table): JsonResponse
    {
        $data = new CmsTableApi(...$request->validated());

        $table->query = $data->query;
        $table->mutable = $data->mutable;
        $table->queryable = $data->queryable;
        $table->deletable = $data->deletable;

        $table->columns->map(fn (CmsColumn $column) => $data->setColumnData($column));

        DB::connection('cms')->transaction(function () use ($table) {
            $table->save();
            $table->columns()->saveMany($table->columns);
        });

        return Response::create()->addPopup(
            SimpleNotificationComponent::create()->setText(trans(
                'response.success.saved'
            ))
        )->toJson();
    }
}
