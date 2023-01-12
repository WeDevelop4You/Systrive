<?php

namespace App\Account\Settings\Responses;

use App\Account\Settings\Forms\SettingsPersonalForm;
use App\Account\Settings\Resources\UserPersonalResource;
use Illuminate\Support\Facades\Auth;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\BreadcrumbAction;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Client\Components\Misc\CardHeaderComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Overviews\CardComponent;
use Support\Client\Components\Overviews\ListItems\ListItemContentComponent;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyAlignType;
use Support\Enums\Component\Vuetify\VuetifyJustifyType;

class SettingsPersonalOverviewResponse extends AbstractResponse
{
    protected function handle(): Response
    {
        return Response::create()
            ->addAction(
                ChainAction::create()->setActions([
                    BreadcrumbAction::create()->add(trans('word.personal')),
                    VuexAction::create()->commit(
                        'settings/personal/form/setEdit',
                        UserPersonalResource::make(Auth::user())
                    ),
                ])
            )
            ->addComponent(
                RowComponent::create()
                    ->setNoGutters()
                    ->setClass('gap-3')
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
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.personal.data'))
                    )
                    ->addBody(
                        SettingsPersonalForm::create()
                            ->setVuexNamespace('settings/personal/form')
                    )
                    ->setFooter(
                        MultipleButtonComponent::create()
                            ->setClass('px-2')
                            ->addButton(
                                ButtonComponent::create()
                                    ->setColor()
                                    ->setTitle(trans('word.save.save'))
                                    ->setAction(
                                        VuexAction::create()
                                            ->dispatch(
                                                'settings/personal/update',
                                                route('account.settings.personal')
                                            )
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
                    ->setHeader(
                        CardHeaderComponent::create()
                            ->setTitle(trans('word.preferences'))
                    )
                    ->addBody(
                        RowComponent::create()
                            ->setAlign(VuetifyAlignType::CENTER)
                            ->setJustify(VuetifyJustifyType::SPACE_BETWEEN)
                            ->setCols([
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        ListItemContentComponent::create()
                                            ->setClass('mb-0')
                                            ->setValue(trans('word.language'))
                                    ),
                                ColComponent::create()
                                    ->setDefaultCol('auto')
                                    ->setComponent(
                                        CustomComponent::create()->setType('LocaleDropdownComponent')
                                    ),
                            ])
                    )
            );
    }
}
