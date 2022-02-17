<?php

    namespace Domain\Invite\Actions;

    use Domain\Invite\DataTransferObject\InviteData;
    use Domain\Invite\Mappings\InviteTableMap;
    use Domain\Invite\Models\Invite;
    use Domain\User\Mappings\UserTableMap;
    use Domain\User\Models\User;
    use Support\Enums\SessionKeyTypes;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Exceptions\InviteNewUserException;
    use Support\Helpers\Response\Action\Methods\RequestMethods;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\ConfirmModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
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
         * @throws InviteNewUserException
         */
        public function __invoke(Invite $invite)
        {
            if ($this->isNewUser($invite->email)) {
                $inviteData = new InviteData($invite->company_id, $this->token, $this->encryptEmail);

                Response::create()->addData($inviteData->export())->toSession(SessionKeyTypes::REGISTRATION);

                throw new InviteNewUserException();
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
        }

        /**
         * @param string $email
         *
         * @return bool
         */
        private function isNewUser(string $email): bool
        {
            return User::withTrashed()->whereEmail($email)->whereNull(UserTableMap::PASSWORD)->exists();
        }

        private function createInviteAccepted(int $companyId)
        {
            Response::create()->addAction(
                RequestMethods::create()
                    ->get(route('admin.company.user.invite.accepted', [$companyId, $this->token]))
            )->toSession(SessionKeyTypes::KEEP);
        }

        private function createCompanyComplete(int $companyId)
        {
            Response::create()->addPopup(
                ConfirmModal::create()
                    ->setTitle(trans('modal.confirm.company.complete.title'))
                    ->setText(trans('modal.confirm.company.complete.text'))
                    ->addButton(
                        Button::create()
                            ->setTitle(trans('modal.cancel.cancel'))
                            ->setType(VuetifyButtonTypes::TEXT)
                            ->setAction(
                                RequestMethods::create()
                                    ->delete(route('admin.session.delete', ['key' => SessionKeyTypes::KEEP->value]))
                            )
                    )->addButton(
                        Button::create()
                            ->setTitle(trans('modal.complete.complete'))
                            ->setColor()
                            ->setAction(
                                RequestMethods::create()
                                    ->get(route('admin.company.complete', [$companyId, $this->token]))
                            )
                    )
            )->toSession(SessionKeyTypes::KEEP);
        }
    }
