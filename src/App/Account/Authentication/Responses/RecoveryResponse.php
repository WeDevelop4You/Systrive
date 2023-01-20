<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\RecoveryForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\ContentComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyButtonType;

class RecoveryResponse extends AbstractResponse
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
                            ->setContent('title', trans('word.password.forgot'))
                    )
                    ->setSubBody(
                        ContentComponent::create()
                            ->setValue(trans('text.password.forgot'))
                            ->setClass(['text-center text--disabled mb-0'])
                    )
                    ->addBody(
                        RecoveryForm::create()->setVuexNamespace('guest/recovery/form')
                    )
                    ->setFooter(
                        MultipleButtonComponent::create()
                            ->addButton(
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setType(VuetifyButtonType::BLOCK)
                                    ->setTitle(trans('word.send.email'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'guest/recovery/send',
                                            route('account.recovery')
                                        )
                                    )
                            )
                    )
            );
    }
}
