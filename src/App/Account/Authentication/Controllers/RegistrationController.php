<?php

namespace App\Account\Authentication\Controllers;

use App\Account\Authentication\Requests\RegistrationRequest;
use App\Account\Authentication\Responses\RegistrationResponse;
use Domain\Authentication\Actions\RegisterUserAction;
use Domain\Invite\Actions\ValidateInviteTokenAction;
use Domain\Invite\DataTransferObject\InviteData;
use Domain\Invite\Exceptions\InvalidTokenException;
use Domain\User\DataTransferObjects\UserProfileData;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Support\Client\Actions\RouteAction;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Enums\SessionKeyType;
use Support\Helpers\ApplicationHelper;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RegistrationController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $response = Response::create();

        if (Session::has(SessionKeyType::REGISTRATION->value)) {
            try {
                $inviteData = new InviteData(...Response::getSessionData(SessionKeyType::REGISTRATION));

                $invite = (new ValidateInviteTokenAction())($inviteData);

                return RegistrationResponse::create($invite)->toJson();
            } catch (DecryptException|ModelNotFoundException|InvalidTokenException) {
                $response = Response::create()->addPopup(
                    SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')),
                    ResponseCode::HTTP_BAD_REQUEST
                );
            }
        }

        return $response->addAction(
            RouteAction::create()->goTo(VueRouteHelper::create()->setName('login'))
        )->toJson();
    }

    /**
     * @param RegistrationRequest $request
     *
     * @return JsonResponse
     */
    public function action(RegistrationRequest $request): JsonResponse
    {
        $response = Response::create();

        if (Session::has(SessionKeyType::REGISTRATION->value)) {
            $data = new UserProfileData(...$request->only([
                'first_name',
                'middle_name',
                'last_name',
                'gender',
                'birth_date',
            ]));

            try {
                (new RegisterUserAction($request->get('password')))($data);

                Response::create()
                    ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.registered.and.accepted')))
                    ->toSession();

                return $response->addRedirect(ApplicationHelper::getRedirectRoute())->toJson();
            } catch (DecryptException|ModelNotFoundException|InvalidTokenException) {
            }
        }

        return $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')))
            ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST)
            ->toJson();
    }
}
