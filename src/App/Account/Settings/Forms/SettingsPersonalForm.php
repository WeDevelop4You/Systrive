<?php

namespace App\Account\Settings\Forms;

use Domain\User\Mappings\UserProfileTableMap;
use Domain\User\Mappings\UserTableMap;
use Support\Abstracts\AbstractForm;
use Support\Client\Components\Forms\FormComponent;
use Support\Client\Components\Forms\Inputs\DatePickerInputComponent;
use Support\Client\Components\Forms\Inputs\SelectInputComponent;
use Support\Client\Components\Forms\Inputs\TextInputComponent;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Forms\Utils\KeyValueObject;
use Support\Client\Components\Layouts\ColComponent;

class SettingsPersonalForm extends AbstractForm
{
    /**
     * @inheritDoc
     */
    protected function handle(): FormComponent
    {
        return FormComponent::create()
            ->setItems([
                InputColWrapper::create()
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(UserTableMap::COL_EMAIL)
                            ->setLabel(trans('word.email.email'))
                    ),
                InputColWrapper::create()
                    ->setCol(ColComponent::create()->setDefaultCol(8))
                    ->setInput(
                        TextInputComponent::create()
                            ->setKey(UserProfileTableMap::COL_FIRST_NAME)
                            ->setLabel(trans('word.first_name'))
                    ),
                InputColWrapper::create()
                    ->setCol(ColComponent::create()->setDefaultCol(4))
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
                    ->setCol(ColComponent::create()->setDefaultCol(6))
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
                    ->setCol(ColComponent::create()->setDefaultCol(6))
                    ->setInput(
                        DatePickerInputComponent::create()
                            ->setKey(UserProfileTableMap::COL_BIRTH_DATE)
                            ->setLabel(trans('word.birth_date'))
                    ),
            ]);
    }
}
