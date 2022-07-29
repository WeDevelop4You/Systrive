<?php

namespace App\Admin\Account\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\FormTypes;
use Support\Enums\Component\Vuetify\VuetifyAlignTypes;
use Support\Enums\Component\Vuetify\VuetifyJustifyTypes;
use Support\Response\Actions\BreadcrumbAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\CustomComponent;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Response;

class AccountSettingsPersonalOverviewResponse extends AbstractResponse
{
    protected function handle(): Response
    {
        return Response::create()
            ->addAction(
                BreadcrumbAction::create()->add(trans('word.personal'))
            )
            ->addComponent(
                RowComponent::create()
                    ->setNoGutters()
                    ->addClass('gap-3')
                    ->setCols([
                        $this->createForm(),
                        $this->createPreferences(),
                    ])
            );
    }

    /**
     * @return ColComponent
     */
    private function createForm(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.personal.data'))
                    ->addBody(
                        CustomFormComponent::create()
                            ->setType(FormTypes::USER_PROFILE)
                            ->setVuexNamespace('user/auth/form')
                    )
                    ->setFooterButton(
                        MultipleButtonComponent::create()
                            ->addClass('px-2')
                            ->addButton(
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setTitle(trans('word.save.save'))
                                    ->setAction(
                                        VuexAction::create()
                                            ->dispatch('user/auth/update')
                                    )
                            )
                    )
            );
    }

    /**
     * @return ColComponent
     */
    private function createPreferences(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.preferences'))
                    ->addBody(
                        RowComponent::create()
                            ->setAlign(VuetifyAlignTypes::CENTER)
                            ->setJustify(VuetifyJustifyTypes::SPACE_BETWEEN)
                            ->setCols([
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        ItemTextComponent::create()
                                            ->addClass('mb-0')
                                            ->setValue(trans('word.language'))
                                    ),
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        CustomComponent::create()
                                            ->setType('LocaleDropdown')
                                    ),
                            ])
                    )
            );
    }
}
