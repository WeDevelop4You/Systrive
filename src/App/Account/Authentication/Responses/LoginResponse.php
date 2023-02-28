<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\LoginForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RouteAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Menu\Helpers\VueRouteHelper;
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
                        WrapperComponent::create()
                            ->setClass('gap-3')
                            ->setComponents([
                                BtnComponentType::create()
                                    ->setColor()
                                    ->setType(VuetifyButtonType::BLOCK)
                                    ->setTitle(trans('word.login.login'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'guest/login/send',
                                            route('account.login')
                                        )
                                    ),
                                BtnComponentType::create()
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
