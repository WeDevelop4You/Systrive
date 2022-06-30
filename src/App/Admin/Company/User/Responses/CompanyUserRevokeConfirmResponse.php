<?php

namespace App\Admin\Company\User\Responses;

use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Support\Abstracts\AbstractResponse;
use Support\Response\Actions\RequestAction;
use Support\Response\Components\Popups\Modals\DeleteModal;
use Support\Response\Response;

class CompanyUserRevokeConfirmResponse extends AbstractResponse
{
    public function __construct(
        private readonly Company $company,
        private readonly User $user
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $modal = DeleteModal::create();

        return Response::create()
            ->addPopup(
                DeleteModal::create('company/users')
                    ->setTitle(trans('word.revoke.revoke'))
                    ->setText(trans('modal.revoke.text'))
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(
                                route('admin.company.user.revoke', [
                                    $this->company->id,
                                    $this->user->id,
                                ])
                            ),
                        trans('word.revoke.revoke')
                    )
                    ->addFooterCancelButton()
            );
    }
}
