<?php

    namespace Domain\Invite\Actions;

    use Domain\Invite\Models\Invite;
    use Domain\User\Models\User;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Helpers\Response\Action\Methods\RequestMethod;
    use Support\Helpers\Response\Popups\Modals\ConfirmModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Support\Helpers\Vuetify;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class InviteTokenAction
    {
        public function __construct(
            private string $token,
            private string $encryptEmail
        ) {
            //
        }

        /**
         * @param Invite $userInvite
         *
         * @return RedirectResponse
         */
        public function __invoke(Invite $userInvite): RedirectResponse
        {
            $response = new Response();

            if ($userInvite->type === Invite::COMPANY_USER_TYPE) {
                if ($this->isNewUser($userInvite->email)) {
                    return $this->createRegistration($userInvite->company_id);
                }

                $response->addAction(
                    RequestMethod::create()->get(
                        route('admin.company.user.invite.accepted', [$userInvite->company_id, $this->token])
                    )
                )->toSession(Response::SESSION_KEY_MODAL);
            } elseif ($userInvite->type === Invite::NEW_COMPANY_TYPE) {
                if (Auth::check()) {
                    $this->createConfirmUseAuthUser($userInvite->company_id);
                }

                $this->createNewUser($userInvite->company_id);
            } else {
                $response->addPopup(new SimpleNotification(trans('response.error.invite.unknown.type')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                    ->toSession();
            }

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

        /**
         * @param int $companyId
         *
         * @return RedirectResponse
         */
        private function createRegistration(int $companyId): RedirectResponse
        {
            Response::create()
                ->addData([
                    $companyId,
                    $this->token,
                    $this->encryptEmail,
                ])->toSession(Response::SESSION_KEY_REGISTRATION);

            return redirect()->route('admin.web.registration');
        }

        private function createNewUser(int $companyId): void
        {
            Response::create()
                ->addPopup(
                    ConfirmModal::create()
                        ->setTitle(trans('modal.confirm.login.user.title'))
                        ->setText(trans('modal.confirm.login.user.text'))
                        ->setAcceptText(trans('modal.confirm.login.new.user'))
                        ->setAcceptUrl(route('admin.user.create', [$companyId, $this->token, $this->encryptEmail]))
                        ->setCancelText(trans('modal.confirm.login.login'))
                        ->setCancelUrl(route('admin.session.delete', ['key' => Response::SESSION_KEY_MODAL_LOGIN]))
                )->toSession(Response::SESSION_KEY_MODAL_LOGIN);
        }

        /**
         * @param int $companyId
         *
         * @return void
         */
        private function createConfirmUseAuthUser(int $companyId): void
        {
            Response::create()
                ->addPopup(
                    ConfirmModal::create()
                        ->setTitle(trans('modal.confirm.auth.user.title'))
                        ->setText(trans('modal.confirm.auth.user.text'))
                        ->setAcceptText(trans('modal.confirm.auth.existing.user'))
                        ->setAcceptUrl(route('admin.company.complete', [$companyId, $this->token]))
                        ->setAcceptMethod(Vuetify::GET_METHOD)
                        ->setCancelText(trans('modal.confirm.auth.other.user'))
                        ->setCancelUrl(route('admin.user.logout'))
                    ->setCancelMethod(Vuetify::GET_METHOD)
                )->toSession(Response::SESSION_KEY_MODAL);
        }
    }
