<?php

namespace App\Admin\Account\Responses;

use Domain\User\Mappings\UserSecurityTableMap;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Enums\FormTypes;
use Support\Enums\Vuetify\VuetifyAlignTypes;
use Support\Enums\Vuetify\VuetifyColors;
use Support\Enums\Vuetify\VuetifyJustifyTypes;
use Support\Response\Actions\BreadcrumbAction;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Buttons\MultipleButtonComponent;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Items\ItemTextComponent;
use Support\Response\Components\Layouts\ColComponent;
use Support\Response\Components\Layouts\RowComponent;
use Support\Response\Components\Overviews\CardComponent;
use Support\Response\Response;

class AccountSettingsSecurityOverviewResponse extends AbstractResponse
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
                    ->addClass('gap-3')
                    ->setCols([
                        $this->createPassword(),
                        $this->createOneTimePassword(),
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
                    ->setTitle(trans('word.password.password'))
                    ->addBody(
                        CustomFormComponent::create()
                            ->setType(FormTypes::PASSWORD)
                            ->setVuexNamespace('user/auth/settings/passwordForm')
                    )
                    ->setFooterButton(
                        MultipleButtonComponent::create()
                            ->addClass('px-2')
                            ->addButton(
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setTitle(trans('word.save.save'))
                                    ->setAction(
                                        VuexAction::create()->dispatch(
                                            'user/auth/settings/updatePassword',
                                            route('admin.account.change.password')
                                        )
                                    )
                            )
                    )
            );
    }

    /**
     * @return ColComponent
     */
    private function createOneTimePassword(): ColComponent
    {
        $isEnabled = Auth::user()
            ->security()
            ->where(UserSecurityTableMap::ENABLED, true)
            ->exists();

        return ColComponent::create()
            ->setComponent(
                CardComponent::create()
                    ->setTitle(trans('word.one_time_password'))
                    ->addBody(
                        RowComponent::create()
                            ->setJustify(VuetifyJustifyTypes::SPACE_BETWEEN)
                            ->setAlign(VuetifyAlignTypes::CENTER)
                            ->setCols([
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        ItemTextComponent::create()
                                            ->addClass('mb-0')
                                            ->setValue(
                                                $isEnabled
                                                ? trans('text.one_time_password.enabled')
                                                : trans('text.one_time_password.disable')
                                            )
                                    ),
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        MultipleButtonComponent::create()
                                            ->addClass('gap-3')
                                            ->addButtonIf(
                                                !$isEnabled,
                                                ButtonComponent::create()
                                                    ->setColor()
                                                    ->setTitle(trans('word.enable.enable'))
                                                    ->setAction(
                                                        VuexAction::create()
                                                            ->dispatch(
                                                                'user/auth/settings/createOneTimePassword',
                                                                route('admin.account.settings.otp.qrcode')
                                                            )
                                                    )
                                            )
                                            ->addButtonIf(
                                                $isEnabled,
                                                ButtonComponent::create()
                                                    ->setColor()
                                                    ->setTarget('blank')
                                                    ->setTitle(trans('word.downloaded.recovery.codes'))
                                                    ->setHref(route('admin.account.download.recovery.codes'))
                                            )
                                            ->addButtonIf(
                                                $isEnabled,
                                                ButtonComponent::create()
                                                    ->setColor(VuetifyColors::ERROR)
                                                    ->setTitle(trans('word.disable.disable'))
                                                    ->setAction(
                                                        RequestAction::create()
                                                            ->delete(route('admin.account.settings.otp.disable'))
                                                    )
                                            )
                                    ),
                            ])
                    )
            );
    }
}
