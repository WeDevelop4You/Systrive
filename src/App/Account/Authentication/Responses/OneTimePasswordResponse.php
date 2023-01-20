<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\OneTimePasswordForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\ChainAction;
use Support\Client\Actions\RequestAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyButtonType;
use Support\Enums\Component\Vuetify\VuetifyColor;
use Support\Enums\Component\Vuetify\VuetifySizeType;

class OneTimePasswordResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $modal = FormModal::create('guest/login/form');

        $modal->getModal()->setCloseAction(
            VuexAction::create()->commit('guest/login/reset')
        );

        return Response::create()
            ->addPopup(
                $modal->setWidth(323)
                    ->setTitle(trans('word.verify.title'))
                    ->setForm(OneTimePasswordForm::create())
                    ->addFooter(
                        ButtonComponent::create()
                            ->setColor()
                            ->setType(VuetifyButtonType::BLOCK)
                            ->setTitle(trans('modal.verify.verify'))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'guest/login/send',
                                    route('account.login.otp')
                                )
                            )
                    )
                    ->addFooter(
                        ButtonComponent::create()
                            ->setSize(VuetifySizeType::X_SMALL)
                            ->setType(VuetifyButtonType::BLOCK)
                            ->setColor(VuetifyColor::TRANSPARENT)
                            ->setTitle(trans('word.recovery.code'))
                            ->setAction(
                                ChainAction::create()
                                    ->addAction(
                                        RequestAction::create()
                                            ->get(route('account.recovery.code'))
                                            ->setCloseModalOnSuccessAction($modal->getIdentifier())
                                    )->addAction(
                                        VuexAction::create()->commit('guest/login/reset')
                                    )
                            )
                    )
            );
    }
}
