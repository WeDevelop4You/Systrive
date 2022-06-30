<?php

namespace App\Admin\Company\User\Responses;

use App\Admin\Company\User\Resources\CompanyUserEditResource;
use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Support\Abstracts\AbstractResponse;
use Support\Enums\FormTypes;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class CompanyUserEditResponse extends AbstractResponse
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
            ->addData(CompanyUserEditResource::make($this->user))
            ->addPopup(
                FormModal::create('company/users/form')
                    ->setPersistent()
                    ->setTitle(trans('word.edit.edit'))
                    ->setForm(
                        CustomFormComponent::create()
                            ->setType(FormTypes::COMPANY_USER)
                    )
                    ->addFooterCancelButton()
                    ->addFooterSaveButton(
                        VuexAction::create()->dispatch(
                            'company/users/update',
                            route('admin.company.user.edit', [
                                $this->company->id,
                                $this->user->id,
                            ])
                        )
                    )
            );
    }
}
