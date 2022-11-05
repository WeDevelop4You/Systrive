<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyCreateRequest;
    use App\Admin\Company\Responses\CompanyInviteResponse;
    use Domain\Company\Actions\CompanyStoreAction;
    use Domain\Invite\DataTransferObject\CompanyInviteData;
    use Illuminate\Http\JsonResponse;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class CompanyInviteController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return CompanyInviteResponse::create()->toJson();
        }

        /**
         * @param CompanyCreateRequest $requests
         *
         * @return JsonResponse
         */
        public function action(CompanyCreateRequest $requests): JsonResponse
        {
            $data = new CompanyInviteData(...$requests->validated());

            (new CompanyStoreAction())($data);

            return Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.saved')))
                ->setStatusCode(ResponseCode::HTTP_CREATED)
                ->toJson();
        }
    }
