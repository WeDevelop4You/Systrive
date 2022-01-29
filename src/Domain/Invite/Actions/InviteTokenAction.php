<?php

    namespace Domain\Invite\Actions;

    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Domain\User\Models\User;
    use Illuminate\Http\RedirectResponse;
    use Support\Helpers\Response\Action\Methods\RequestMethod;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\ConfirmModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Support\Helpers\VuetifyHelper;
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
         * @param Invite $invite
         *
         * @return RedirectResponse
         */
        public function __invoke(Invite $invite): RedirectResponse
        {
            if ($this->isNewUser($invite->email)) {
                $inviteData = new InviteData($invite->company_id, $this->token, $this->encryptEmail);

                Response::create()->addData($inviteData->export())->toSession(Response::SESSION_KEY_REGISTRATION);

                return redirect()->route('admin.web.registration');
            }

            switch ($invite->type) {
                case InviteTableMap::USER_TYPE:
                    $this->createInviteAccepted($invite->company_id);

                    break;
                case InviteTableMap::COMPANY_TYPE:
                    $this->createCompanyComplete($invite->company_id);

                    break;
                default:
                    Response::create()
                        ->addPopup(new SimpleNotification(trans('response.error.invite.unknown.type')))
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

        private function createInviteAccepted(int $companyId)
        {
            Response::create()
                ->addAction(
                    RequestMethod::create()
                        ->get(route('admin.company.user.invite.accepted', [$companyId, $this->token]))
                )
                ->toSession(Response::SESSION_KEY_MODAL);
        }

        private function createCompanyComplete(int $companyId)
        {
            $cancelButton = Button::create()
                ->setTitle(trans('modal.confirm.cancel.cancel'))
                ->setType(VuetifyHelper::TEXT_BUTTON_TYPE)
                ->setRequestUrl(route('admin.session.delete', ['key' => Response::SESSION_KEY_MODAL]))
                ->setRequestMethod(VuetifyHelper::DELETE_METHOD);

            $completeButton = Button::create()
                ->setTitle(trans('modal.confirm.company.complete.accept'))
                ->setColor(VuetifyHelper::PRIMARY_COLOR)
                ->setRequestUrl(route('admin.company.complete', [$companyId, $this->token]))
                ->setRequestMethod(VuetifyHelper::GET_METHOD);

            Response::create()
                ->addPopup(
                    ConfirmModal::create()
                        ->setTitle(trans('modal.confirm.company.complete.title'))
                        ->setText(trans('modal.confirm.company.complete.text'))
                        ->addButton($cancelButton)
                        ->addButton($completeButton)
                )
                ->toSession(Response::SESSION_KEY_MODAL);
        }
    }
