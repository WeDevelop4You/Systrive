<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\LoginForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RouteAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyButtonType;
use Support\Enums\Component\Vuetify\VuetifySizeType;

class LoginResponse extends AbstractResponse
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
                    ->addBody(
                        LoginForm::create()->setVuexNamespace('guest/login/form')
                    )
                    ->setFooter(
                        MultipleButtonComponent::create()
                            ->setClass('gap-3')
                            ->setButtons([
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setType(VuetifyButtonType::BLOCK)
                                    ->setTitle(trans('word.login.login'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'guest/login/send',
                                            route('account.login')
                                        )
                                    ),
                                ButtonComponent::create()
                                    ->setSize(VuetifySizeType::X_SMALL)
                                    ->setType(VuetifyButtonType::BLOCK)
                                    ->setTitle(trans('word.password.forgot'))
                                    ->setAction(
                                        RouteAction::create()->goTo(VueRouteHelper::create()->setName('recovery'))
                                    ),
                            ])
                    )
            );
    }
}
