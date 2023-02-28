<?php

namespace App\Account\Settings\Responses;

use App\Account\Settings\Forms\SettingsPasswordForm;
use Domain\User\Mappings\UserSecurityTableMap;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\BreadcrumbAction;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\BtnComponentType;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Layouts\WrapperComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyAlignType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifyJustifyType;

class SettingsSecurityOverviewResponse extends AbstractResponse
{
    protected function handle(): Response
    {
        return Response::create()
            ->addAction(
                BreadcrumbAction::create()->add(trans('word.security'))
            )
            ->addComponent(
                RowComponent::create()
                    ->setNoGutters()
                    ->setClass('gap-3')
                    ->setCols([
                        $this->createPassword(),
                        $this->createTwoFactorAuthentication(),
                    ])
            );
    }

    /**
     * @return ColComponent
     */
    private function createPassword(): ColComponent
    {
        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.password.password'))
                    )
                    ->addBody(SettingsPasswordForm::create()->setVuexNamespace('settings/password/form'))
                    ->setFooter(
                        WrapperComponent::create()
                            ->setClass('px-2')
                            ->addComponent(
                                BtnComponentType::create()
                                    ->setColor()
                                    ->setTitle(trans('word.save.save'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'settings/password/update',
                                            route('account.settings.password')
                                        )
                                    )
                            )
                    )
            );
    }

    /**
     * @return ColComponent
     */
    private function createTwoFactorAuthentication(): ColComponent
    {
        $isEnabled = Auth::user()
            ->security()
            ->where(UserSecurityTableMap::COL_ENABLED, true)
            ->exists();

        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.one_time_password'))
                    )
                    ->addBody(
                        RowComponent::create()
                            ->setJustify(VuetifyJustifyType::SPACE_BETWEEN)
                            ->setAlign(VuetifyAlignType::CENTER)
                            ->setCols([
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        ListItemContentComponent::create()
                                            ->setClass('mb-0')
                                            ->setValue(
                                                $isEnabled
                                                ? trans('text.one_time_password.enabled')
                                                : trans('text.one_time_password.disable')
                                            )
                                    ),
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        WrapperComponent::create()
                                            ->setClass('gap-3')
                                            ->addComponentIf(
                                                !$isEnabled,
                                                BtnComponentType::create()
                                                    ->setColor()
                                                    ->setTitle(trans('word.enable.enable'))
                                                    ->setAction(RequestAction::create()->get(
                                                        route('account.settings.2fa.qrcode')
                                                    ))
                                            )
                                            ->addComponentIf(
                                                $isEnabled,
                                                BtnComponentType::create()
                                                    ->setColor()
                                                    ->setTitle(trans('word.downloaded.recovery.codes'))
                                                    ->setHref(route('account.settings.download.recovery.codes'))
                                            )
                                            ->addComponentIf(
                                                $isEnabled,
                                                BtnComponentType::create()
                                                    ->setColor(VuetifyColor::ERROR)
                                                    ->setTitle(trans('word.disable.disable'))
                                                    ->setAction(RequestAction::create()->delete(
                                                        route('account.settings.2fa.disable')
                                                    ))
                                            )
                                    ),
                            ])
                    )
            );
    }
}
