<?php

namespace App\Admin\Cms\Controllers;

use App\Admin\Cms\Requests\CmsStoreRequest;
use App\Admin\Cms\Responses\CmsResponse;
use Domain\Cms\Actions\CmsCreateAction;
use Domain\Cms\DataTransferObjects\CmsData;
use Domain\Company\Models\Company;
use Illuminate\Http\JsonResponse;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Exceptions\Custom\UnknownResponseCodeException;
use Support\Exceptions\Custom\Vesta\VestaCommandException;
use Support\Services\Vesta;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CmsCreateController
{
    /**
     * @param Company $company
     *
     * @return JsonResponse
     */
    public function index(Company $company): JsonResponse
    {
        return CmsResponse::create($company)->toJson();
    }

    /**
     * @param CmsStoreRequest $request
     * @param Company         $company
     *
     * @throws UnknownResponseCodeException
     *
     * @return JsonResponse
     */
    public function action(CmsStoreRequest $request, Company $company): JsonResponse
    {
        $data = new CmsData(...$request->validated());

        try {
            (new CmsCreateAction($company))($data);
        } catch (VestaCommandException $e) {
            $message = Vesta::getResponseCodeTranslation($e->getCode());

            return Response::create()
                ->addErrors('name', [$message])
                ->toJson();
        }

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.saved')),
                ResponseCode::HTTP_CREATED
            )->toJson();
    }
}
