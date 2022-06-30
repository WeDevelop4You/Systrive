<?php

namespace App\Admin\Invite\Controllers;

use App\Admin\Invite\Responses\InviteStateResponse;
use Domain\Company\Models\Company;
use Domain\Invite\Actions\ValidateInviteTokenAction;
use Domain\Invite\DataTransferObject\InviteData;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Support\Exceptions\InvalidTokenException;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class InviteStateController
{
    /**
     * @param Company $company
     * @param string  $token
     * @param string  $encryptEmail
     *
     * @return RedirectResponse
     */
    public function index(Company $company, string $token, string $encryptEmail): RedirectResponse
    {
        try {
            $invite = (new ValidateInviteTokenAction())(new InviteData($company->id, $token, $encryptEmail));

            $response = InviteStateResponse::create($invite, $token, $encryptEmail);
        } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
            $response = Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.invalid.token')))
                ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                ->toSession()
                ->addRedirect(route('admin.dashboard'));
        }

        return $response->toRedirect();
    }
}
