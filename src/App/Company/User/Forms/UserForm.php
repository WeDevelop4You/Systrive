<?php

namespace App\Company\User\Forms;

use App\Company\Role\Resources\RoleListResource;
use Domain\Company\Models\Company;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\Custom\CustomPermissionInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Enums\Component\Form\FormPermissionInputType;

class UserForm extends AbstractForm
{
    public function __construct(
        private readonly Company $company,
        private readonly bool $isEditing = false
    ) {
      //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): FormComponent
    {
        $roles = $this->company->roles()->with('permissions')->get();

        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setCondition(!$this->isEditing)
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('email')
                            ->setLabel(trans('word.email.email'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        CustomPermissionInputComponent::create()
                            ->setKey('roles')
                            ->setLabel(trans('word.roles'))
                            ->setType(FormPermissionInputType::USER)
                            ->setRoles(RoleListResource::collection($roles)->toArray(request()))
                    ),
            ]);
    }
}
