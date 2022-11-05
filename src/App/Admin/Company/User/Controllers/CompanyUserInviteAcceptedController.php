<?php

    namespace App\Admin\Company\User\Controllers;

    use Domain\Company\Actions\CompanyUserUpdateInviteToAcceptedAction;
    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Exceptions\InvalidTokenException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Enums\Component\ModalCloseType;
    use Support\Enums\SessionKeyType;
    use Support\Response\Actions\RequestAction;
    use Support\Response\Actions\VuexAction;
    use Support\Response\Components\Popups\Modals\ConfirmModal;
    use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
    use Support\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCode;

    class CompanyUserInviteAcceptedController
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

                $response->addPopup(
                    ConfirmModal::create()
                        ->setTitle(trans('modal.confirm.accepted.invite.company.title'))
                        ->setText(trans('modal.confirm.accepted.invite.company.text'))
                        ->addFooterCancelButton(
                            action: RequestAction::create()
                                ->forgetSessionKey(),
                            close: ModalCloseType::SUCCESS
                        )
                        ->addFooterSubmitButton(
                            action: RequestAction::create()
                                ->post(route('admin.company.user.invite.accepted', [$company->id, $token])),
                            close: ModalCloseType::SUCCESS
                        )
                );
            } catch (ModelNotFoundException | InvalidTokenException) {
                Session::forget(SessionKeyType::KEEP->value);

                $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
            }

            return $response->toJson();
        }

        /**
         * @param Company $company
         * @param string  $token
         *
         * @return JsonResponse
         */
        public function action(Company $company, string $token): JsonResponse
        {
            $response = new Response();

            try {
                (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

                (new CompanyUserUpdateInviteToAcceptedAction(Auth::user()))($company);

                $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.company.invite.accepted')))
                    ->addAction(VuexAction::create()->dispatch('navigation/getCompanies'));
            } catch (ModelNotFoundException | InvalidTokenException) {
                $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST);
            }

            Session::forget(SessionKeyType::KEEP->value);

            return $response->toJson();
        }
    }
