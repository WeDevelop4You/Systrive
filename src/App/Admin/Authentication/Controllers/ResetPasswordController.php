<?php

namespace App\Admin\Authentication\Controllers;

use App\Admin\Authentication\Requests\ResetPasswordRequest;
use Domain\User\Actions\UpdatePasswordAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use function route;
use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;
use function trans;
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
        return view('admin::pages.reset-password')->with([
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
                (new UpdatePasswordAction($user))($password);
            }
        );

        $response = new Response();

        if ($status === Password::PASSWORD_RESET) {
            Response::create()
                ->addPopup(new SimpleNotification(trans($status)))
                ->toSession();

            $response->addRedirect(route('admin.login'));
        } else {
            $response->addPopup(new SimpleNotification(trans($status)))
                ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
        }

        return $response->toJson();
    }
}