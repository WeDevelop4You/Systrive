<?php

    namespace App\Admin\Company\Controllers;

    use Domain\Company\Models\Company;
    use Domain\User\Actions\InviteTokenAction;
    use Domain\User\Actions\ValidateInviteTokenAction;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Session;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class CompanyInviteController
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
                $userInvite = (new ValidateInviteTokenAction($company, $token, $encryptEmail))();

                return (new InviteTokenAction($token, $encryptEmail))($userInvite);
            } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                Session::put(
                    Response::SESSION_KEY_DEFAULT,
                    Response::create()
                        ->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                        ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                        ->createResponseContent()
                );
            }

            return redirect()->route('admin.dashboard');
        }
    }
