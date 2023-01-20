<?php

namespace App\Company\Invite\Responses;

use Domain\Invite\DataTransferObject\InviteData;
use Domain\Invite\Enums\InviteTypes;
use Domain\Invite\Models\Invite;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\ConfirmModal;
use Support\Client\Response;
use Support\Enums\Component\ModalCloseType;
use Support\Enums\SessionKeyType;

class InviteStateResponse extends AbstractResponse
{
    protected function __construct(
        private readonly Invite $invite,
        private readonly string $token,
        private readonly string $encryptEmail
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        if ($this->invite->user->isNewUser()) {
            return $this->createNewUserResponse();
        }

        $response = match ($this->invite->type) {
            InviteTypes::USER => $this->createUserResponse(),
            InviteTypes::COMPANY => $this->createCompanyResponse(),
        };

        return $response->toSession(SessionKeyType::KEEP)
            ->addRedirect(route('company.view.switcher'));
    }

    /**
     * @return Response
     */
    private function createNewUserResponse(): Response
    {
        $inviteData = new InviteData(
            $this->invite->company_id,
            $this->token,
            $this->encryptEmail
        );

        return Response::create()
            ->addData($inviteData->export())
            ->toSession(SessionKeyType::REGISTRATION)
            ->addRedirect(route('account.view.registration'));
    }

    /**
     * @return Response
     */
    private function createUserResponse(): Response
    {
        return Response::create()
            ->addAction(
                RequestAction::create()->get(
                    route('company.invite.user.accepted', [
                        $this->invite->company_id, $this->token,
                    ])
                )
            );
    }

    /**
     * @return Response
     */
    private function createCompanyResponse(): Response
    {
        return Response::create()
            ->addPopup(
                ConfirmModal::create()
                    ->setTitle(trans('text.company.complete.title'))
                    ->setText(trans('text.company.complete.text'))
                    ->addFooterCancelButton(
                        RequestAction::create()->forgetSessionKey(),
                        close: ModalCloseType::SUCCESS
                    )
                    ->addFooterSubmitButton(
                        VuexAction::create()->dispatch(
                            'complete',
                            route('company.complete', [
                                $this->invite->company_id, $this->token,
                            ])
                        ),
                        trans('word.complete.company'),
                        ModalCloseType::SUCCESS
                    )
            );
    }
}
