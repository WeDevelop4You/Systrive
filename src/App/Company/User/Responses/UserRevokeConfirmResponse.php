<?php

namespace App\Company\User\Responses;

use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RequestAction;
use Support\Client\Components\Popups\Modals\DeleteModal;
use Support\Client\Response;
use Support\Utils\VuexNamespace;

class UserRevokeConfirmResponse extends AbstractResponse
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
        return Response::create()
            ->addPopup(
                DeleteModal::create(VuexNamespace::createCompanyWhenAdmin('users/dataTable'))
                    ->setTitle(trans('word.revoke.revoke'))
                    ->setText(trans('modal.revoke.text'))
                    ->addFooterDeleteButton(
                        RequestAction::create()
                            ->delete(route('company.user.revoke', [
                                $this->company->id,
                                $this->user->id,
                            ])),
                        trans('word.revoke.revoke')
                    )
                    ->addFooterCancelButton()
            );
    }
}
