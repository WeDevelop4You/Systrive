<?php

namespace App\Admin\Authentication\Controllers;

use App\Admin\Authentication\Requests\RegistrationRequest;
use Domain\Authentication\Actions\RegisterUserAction;
use Domain\Invite\Actions\ValidateInviteTokenAction;
use Domain\Invite\DataTransferObject\InviteData;
use Domain\Invite\Exceptions\InvalidTokenException;
use Domain\User\DataTransferObjects\UserProfileData;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Support\Enums\SessionKeyType;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class RegistrationController
{
    /**
     * @return Application|Factory|RedirectResponse|View
     */
    public function index(): View|Factory|RedirectResponse|Application
    {
        if (Session::has(SessionKeyType::REGISTRATION->value)) {
            try {
                $inviteData = new InviteData(...Response::getSessionData(SessionKeyType::REGISTRATION));

                $invite = (new ValidateInviteTokenAction())($inviteData);

                return view('admin::pages.registration')->with('email', $invite->user->email);
            } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                Response::create()
                    ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST)
                    ->toSession();
            }
        }

        return redirect()->route('admin.web.login');
    }

    /**
     * @param RegistrationRequest $request
     *
     * @return JsonResponse
     */
    public function action(RegistrationRequest $request): JsonResponse
    {
        $response = new Response();

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

                return $response->addRedirect(route('admin.dashboard'))->toJson();
            } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                //
            }
        }

        return $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')))
            ->setStatusCode(ResponseCode::HTTP_BAD_REQUEST)
            ->toJson();
    }
}
