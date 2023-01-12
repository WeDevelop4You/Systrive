<?php

namespace App\Company\User\Responses;

use App\Company\User\Forms\UserForm;
use App\Company\User\Resources\UserCreateResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;
use Support\Helpers\VuexNamespaceHelper;

class UserInviteResponse extends AbstractResponse
{
    public function __construct(
        private readonly company $company
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addData(UserCreateResource::make(null))
            ->addPopup(
                FormModal::create(VuexNamespaceHelper::createCompanyWhenAdmin('users/form'))
                    ->setPersistent()
                    ->setTitle(trans('word.invite.invite'))
                    ->setForm(UserForm::create($this->company))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            VuexNamespaceHelper::createCompanyWhenAdmin('users/store'),
                            route('company.user.invite', [
                                $this->company->id,
                            ])
                        )
                    )
            );
    }
}
