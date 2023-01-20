<?php

namespace App\Company\Company\Controllers;

use App\Company\Company\Requests\CompanyCompleteRequest;
use App\Company\Company\Responses\CompanyCompleteResponse;
use Domain\Company\Actions\CompanyCompleteAction;
use Domain\Company\DataTransferObjects\CompleteCompanyData;
use Domain\Company\Models\Company;
use Domain\Invite\Actions\ValidateInviteTokenAction;
use Domain\Invite\DataTransferObject\InviteData;
use Domain\Invite\Exceptions\InvalidTokenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Support\Client\Actions\RouteAction;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Enums\SessionKeyType;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class CompanyCompleteController
{
    /**
     * @param Company $company
     * @param string  $token
     *
     * @return JsonResponse
     */
    public function index(Company $company, string $token): JsonResponse
    {
        $response = Response::create();

        try {
            (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

            $response = CompanyCompleteResponse::create($company, $token);
        } catch (ModelNotFoundException|InvalidTokenException) {
            Session::forget(SessionKeyType::KEEP->value);

            $response->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.error.invalid.token'))
            )
                ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }

        return $response->toJson();
    }

    /**
     * @param CompanyCompleteRequest $request
     * @param Company                $company
     * @param string                 $token
     *
     * @return JsonResponse
     */
    public function action(CompanyCompleteRequest $request, Company $company, string $token): JsonResponse
    {
        $response = Response::create();

        try {
            (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

            $data = new CompleteCompanyData(...$request->validated());

            (new CompanyCompleteAction($company))($data);

            $response->addAction(
                RouteAction::create()->goTo(VueRouteHelper::createCompany($company))
            )
                ->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.success.company.complete'))
                );
        } catch (ModelNotFoundException|InvalidTokenException) {
            $response->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token'))
            )->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
        }

        Session::forget(SessionKeyType::KEEP->value);

        return $response->toJson();
    }
}
