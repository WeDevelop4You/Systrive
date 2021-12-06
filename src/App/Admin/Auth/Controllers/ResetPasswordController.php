<?php

namespace App\Admin\Auth\Controllers;

use App\Admin\Auth\Requests\ResetPasswordRequest;
use Domain\User\Actions\EditPasswordAction;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

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
        return view('admin::pages.auth.reset-password')->with([
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
                (new editPasswordAction($user))($password);
            }
        );

        $response = new Response();

        if ($status === Password::PASSWORD_RESET) {
            Session::put(Response::SESSION_KEY_DEFAULT, Response::create()
                ->addPopup(new SimpleNotification(trans($status)))
                ->createResponseContent()
            );

            $response->addRedirect(route('admin.login'));
        } else {
            $response->addPopup(new SimpleNotification(trans($status)))
                ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
        }

        return $response->toJson();
    }
}
