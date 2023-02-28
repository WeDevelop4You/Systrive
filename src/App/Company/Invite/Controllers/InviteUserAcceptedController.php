<?php

namespace App\Company\Invite\Controllers;

use Domain\Company\Enums\CompanyStatusTypes;
use Domain\Company\Models\Company;
use Domain\Invite\Actions\CompanyUserUpdateInviteToAcceptedAction;
use Domain\Invite\Actions\ValidateInviteTokenAction;
use Domain\Invite\DataTransferObject\InviteData;
use Domain\Invite\Exceptions\InvalidTokenException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\RouteAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Popups\Modals\ConfirmModal;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Enums\Component\ModalCloseType;
use Support\Enums\SessionKeyType;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class InviteUserAcceptedController
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

            $response->addPopup(
                ConfirmModal::create()
                    ->setTitle(trans('text.invite.user.accepted.title'))
                    ->setText(trans('text.invite.user.accepted.text'))
                    ->addFooterCancelButton(
                        action: RequestAction::create()->forgetSessionKey(),
                        close: ModalCloseType::SUCCESS
                    )
                    ->addFooterSubmitButton(
                        action: RequestAction::create()->post(
                            route('company.invite.user.accepted', [$company->id, $token])
                        ),
                        close: ModalCloseType::SUCCESS
                    )
            );
        } catch (ModelNotFoundException|InvalidTokenException) {
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
        $response = Response::create();

        try {
            (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

            (new CompanyUserUpdateInviteToAcceptedAction(Auth::user()))($company);

            $action = $company->status === CompanyStatusTypes::COMPLETED
                ? RouteAction::create()->goTo(VueRouteHelper::createCompany($company))
                : VuexAction::create()->dispatch(
                    'switcher/component',
                    route('company.switcher.overview')
                );

            $response->addAction($action)->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.success.invite.user.accepted'))
            );
        } catch (ModelNotFoundException|InvalidTokenException) {
            $response->addPopup(
                SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')),
                ResponseCode::HTTP_BAD_REQUEST
            );
        }

        Session::forget(SessionKeyType::KEEP->value);

        return $response->toJson();
    }
}
