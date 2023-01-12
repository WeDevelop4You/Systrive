<?php

namespace App\Company\User\Responses;

use App\Company\User\Forms\UserForm;
use App\Company\User\Resources\UserEditResource;
use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;
use Support\Helpers\VuexNamespaceHelper;

class UserEditResponse extends AbstractResponse
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
            ->addData(UserEditResource::make($this->user))
            ->addPopup(
                FormModal::create(VuexNamespaceHelper::createCompanyWhenAdmin('users/form'))
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(UserForm::create($this->company, true))
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            VuexNamespaceHelper::createCompanyWhenAdmin('users/update'),
                            route('company.user.edit', [
                                $this->company->id,
                                $this->user->id,
                            ])
                        )
                    )
            );
    }
}
