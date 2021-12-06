<?php

    namespace Domain\User\Actions;

    use Domain\User\Models\User;
    use Domain\User\Models\UserInvite;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Session;
    use Support\Helpers\Response\Action\Methods\RequestMethod;
    use Support\Helpers\Response\Response;

    class InviteTokenAction
    {
        public function __construct(
            private string $token,
            private string $encryptEmail
        ) {
            //
        }

        /**
         * @param UserInvite $userInvite
         *
         * @return RedirectResponse
         */
        public function __invoke(UserInvite $userInvite): RedirectResponse
        {
            if ($this->isNewUser($userInvite->email)) {
                Session::put(Response::SESSION_KEY_REGISTRATION, [
                    $userInvite->company_id,
                    $this->token,
                    $this->encryptEmail,
                ]);

                return redirect()->route('admin.web.registration');
            }

            $responseData = new Response();

            if ($userInvite->type === UserInvite::INVITE_USER_TYPE) {
                $responseData->addAction(RequestMethod::create()->get(route(
                    'admin.company.user.invite.accepted',
                    [
                        $userInvite->company_id,
                        $this->token,
                    ]
                )));
            } else {
                $responseData->addAction();
            }

            Session::put(Response::SESSION_KEY_MODAL, $responseData->createResponseContent());

            return redirect()->route('admin.dashboard');
        }

        /**
         * @param string $email
         *
         * @return bool
         */
        private function isNewUser(string $email): bool
        {
            return User::withTrashed()->where('email', $email)->whereNull('password')->exists();
        }
    }
