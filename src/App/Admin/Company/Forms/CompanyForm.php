<?php

namespace App\Admin\Company\Forms;

use Domain\Company\Models\Company;
use Domain\User\Models\User;
use Illuminate\Support\Str;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\CheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\ComboboxInputComponent;
use Support\Client\Components\Forms\Inputs\GroupCheckboxInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Forms\Utils\Logic;

class CompanyForm extends AbstractForm
{
    private int $ownerId;

    public function __construct(
        Company $company,
        private readonly bool $isEditing = false
    ) {
        $this->ownerId = $company->owner?->id ?: 0;
    }

    /**
     * {@inheritDoc}
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('name')
                            ->setLabel(trans('word.name.name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        ComboboxInputComponent::create()
                            ->setClearable()
                            ->setKey('owner')
                            ->setLabel(trans('word.owner'))
                            ->setItems(
                                User::withTrashed()->with('profile')->get()->map(function (User $user) {
                                    $text = Str::of($user->email);

                                    if (!\is_null($user->full_name)) {
                                        $text = $text->append(', (', $user->full_name, ')');
                                    }

                                    return KeyValueObject::create()->setValue($user->id)->setText($text->value());
                                })->toArray()
                            )
                            ->setHideDetails(
                                Logic::condition('owner.value')
                                    ->setValues($this->ownerId)
                                    ->setTrueValue('auto')
                                    ->setFalseValue(true)
                            )
                    ),
                InputColWrapper::create()
                    ->setCondition($this->isEditing)
                    ->setInput(
                        CheckboxInputComponent::create()
                            ->setClass('mb-2')
                            ->setKey('remove_owner')
                            ->setErrorKey('owner')
                            ->setLabel(trans('word.remove.owner'))
                            ->addHiddenLogic(
                                Logic::if('owner.value')->setCompressing($this->ownerId)
                            )
                    ),
                InputColWrapper::create()
                    ->setCondition($this->isEditing)
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('email')
                            ->setLabel(trans('word.email.email'))
                    ),
                InputColWrapper::create()
                    ->setCondition($this->isEditing)
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey('domain')
                            ->setLabel(trans('word.domain.domain'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        GroupCheckboxInputComponent::create()
                            ->setKey('modules')
                            ->setLabel(trans('word.modules'))
                    ),
            ]);
    }
}
