<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyCompleteRequest;
    use App\Admin\Company\Responses\CompanyCreateResponse;
    use Domain\Company\Actions\CompleteCompanyAction;
    use Domain\Company\DataTransferObjects\CompleteCompanyData;
    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Session;
    use Support\Enums\SessionKeyTypes;
    use Support\Exceptions\InvalidTokenException;
    use Support\Response\Actions\RouteAction;
    use Support\Response\Components\Navbar\Helpers\VueRouteHelper;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class CompanyCreateController
    {
        /**
         * @param Company $company
         * @param string  $token
         *
         * @return JsonResponse
         */
        public function index(Company $company, string $token): JsonResponse
        {
            $response = new Response();

            try {
                (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

                $response = CompanyCreateResponse::create($company, $token);
            } catch (ModelNotFoundException | InvalidTokenException) {
                Session::forget(SessionKeyTypes::KEEP->value);

                $response->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.error.invalid.token'))
                )
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
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
            $response = new Response();

            try {
                (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

                $data = new CompleteCompanyData(...$request->validated());

                (new CompleteCompanyAction($company))($data);

                $response->addAction(RouteAction::create()->goTo(VueRouteHelper::getCompany($company)))
                    ->addPopup(
                        SimpleNotificationComponent::create()
                            ->setText(trans('response.success.company.complete'))
                    );
            } catch (ModelNotFoundException | InvalidTokenException) {
                $response->addPopup(
                    SimpleNotificationComponent::create()
                        ->setText(trans('response.error.invalid.token'))
                )
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            Session::forget(SessionKeyTypes::KEEP->value);

            return $response->toJson();
        }
    }
