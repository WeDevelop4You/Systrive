<?php

namespace App\Admin\Authentication\Controllers;

use App\Admin\Authentication\Requests\ResetPasswordRequest;
use Domain\User\Actions\UpdateUserPasswordAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

use function view;

class ResetPasswordController
{
    /**
     * Display a listing of the resource.
     *
     * @param string $token
     * @param string $encryptEmail
     *
     * @return Application|Factory|View
     */
    public function index(string $token, string $encryptEmail): View|Factory|Application
    {
        return \view('admin::pages.reset-password')->with([
            'token' => $token,
            'encryptEmail' => $encryptEmail,
        ]);
    }

    /**
     * @param ResetPasswordRequest $request
     *
     * @return JsonResponse|RedirectResponse
     */
    public function action(ResetPasswordRequest $request): JsonResponse|RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmed', 'token'),
            function ($user, $password) {
                (new UpdateUserPasswordAction($user))($password);
            }
        );

        $response = new Response();

        if ($status === Password::PASSWORD_RESET) {
            Response::create()
                ->addPopup(SimpleNotificationComponent::create()->setText(trans($status)))
                ->toSession();

            $response->addRedirect(route('admin.login'));
        } else {
            $response->addPopup(SimpleNotificationComponent::create()->setText(trans($status)))
                ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
        }

        return $response->toJson();
    }
}
