<?php

namespace App\Account\Authentication\Forms;

use Domain\User\Mappings\UserProfileTableMap;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\DatePickerInputComponent;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Forms\Utils\KeyValueObject;

class ProfileForm extends AbstractForm
{
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
                            ->setKey(UserProfileTableMap::COL_FIRST_NAME)
                            ->setLabel(trans('word.first_name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(UserProfileTableMap::COL_MIDDLE_NAME)
                            ->setLabel(trans('word.middle_name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(UserProfileTableMap::COL_LAST_NAME)
                            ->setLabel(trans('word.last_name'))
                    ),
                InputColWrapper::create()
                    ->setInput(
                        SelectInputComponent::create()
                            ->setKey(UserProfileTableMap::COL_GENDER)
                            ->setLabel(trans('word.gender'))
                            ->setItems([
                                KeyValueObject::create()
                                    ->setText(trans('word.male'))
                                    ->setValue('male'),
                                KeyValueObject::create()
                                    ->setText(trans('word.female'))
                                    ->setValue('female'),
                                KeyValueObject::create()
                                    ->setText(trans('word.other'))
                                    ->setValue('other'),
                            ])
                    ),
                InputColWrapper::create()
                    ->setInput(
                        DatePickerInputComponent::create()
                            ->setKey(UserProfileTableMap::COL_BIRTH_DATE)
                            ->setLabel(trans('word.birth_date'))
                    ),
            ]);
    }
}
