<?php

namespace App\Admin\Invite\Responses;

use Domain\Invite\DataTransferObject\InviteData;
use Domain\Invite\Enums\InviteTypes;
use Domain\Invite\Models\Invite;
use Support\Abstracts\AbstractResponse;
use Support\Enums\SessionKeyTypes;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\ConfirmModal;
use Support\Response\Response;

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
     * @inheritDoc
     */
    protected function handle(): Response
    {
        if ($this->invite->user->isNewUser()) {
            return $this->createNewUserResponse()
                ->addRedirect(route('admin.web.registration'));
        }

        $response = match ($this->invite->type) {
            InviteTypes::USER => $this->createUserResponse(),
            InviteTypes::COMPANY => $this->createCompanyResponse(),
        };

        return $response->addRedirect(route('admin.dashboard'));
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
            ->toSession(SessionKeyTypes::REGISTRATION);
    }

    /**
     * @return Response
     */
    private function createCompanyResponse(): Response
    {
        return Response::create()
            ->addAction(
                RequestAction::create()
                    ->get(route(
                        'admin.company.user.invite.accepted',
                        [$this->invite->company_id, $this->token]
                    ))
            )->toSession(SessionKeyTypes::KEEP);
    }

    /**
     * @return Response
     */
    private function createUserResponse(): Response
    {
        return Response::create()
            ->addPopup(
                ConfirmModal::create()
                    ->setTitle(trans('modal.confirm.company.complete.title'))
                    ->setText(trans('modal.confirm.company.complete.text'))
                    ->addFooterCancelButton(
                        action: RequestAction::create()->forgetSessionKey(),
                        closeModal: true
                    )
                    ->addFooterSubmitButton(
                        RequestAction::create()
                            ->get(route(
                                'admin.company.create',
                                [$this->invite->company_id, $this->token]
                            )),
                        trans('word.complete.complete'),
                        true
                    )
            )->toSession(SessionKeyTypes::KEEP);
    }
}
