<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\ResetPasswordForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyButtonType;

class ResetPasswordResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                CardComponent::create()
                    ->setWidth(400)
                    ->setHeader(
                        CustomComponent::create()
                            ->setType('LogoCardHeaderComponent')
                            ->setContent('title', trans('word.welcome.welcome'))
                    )
                    ->setSubBody(
                        CustomComponent::create()
                            ->setType('PasswordRequirementsComponent')
                            ->setData('vuexNamespace', 'guest/reset/password')
                    )
                    ->addBody(
                        ResetPasswordForm::create()->setVuexNamespace('guest/reset/form')
                    )
                    ->setFooter(
                        WrapperComponent::create()
                            ->addComponent(
                                BtnComponentType::create()
                                    ->setColor()
                                    ->setType(VuetifyButtonType::BLOCK)
                                    ->setTitle(trans('word.password.reset'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'guest/reset/send',
                                            route('account.reset.password')
                                        )
                                    )
                            )
                    )
            );
    }
}
