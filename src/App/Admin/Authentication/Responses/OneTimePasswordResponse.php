<?php

namespace App\Admin\Authentication\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Enums\Component\FormTypes;
use Support\Enums\Component\Vuetify\VuetifyButtonTypes;
use Support\Enums\Component\Vuetify\VuetifyColors;
use Support\Enums\Component\Vuetify\VuetifySizeTypes;
use Support\Response\Actions\ChainAction;
use Support\Response\Actions\RequestAction;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class OneTimePasswordResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $modal = FormModal::create('user/guest/oneTimePasswordForm');

        $modal->getModal()
            ->setCloseAction(
                VuexAction::create()->commit('user/guest/oneTimePasswordForm/setData', [])
            );

        return Response::create()
            ->addPopup(
                $modal->setWidth(323)
                    ->setTitle(trans('modal.verify.title'))
                    ->setForm(
                        CustomFormComponent::create()->setType(FormTypes::ONE_TIME_PASSWORD)
                    )
                    ->addFooterButton(
                        ButtonComponent::create()
                            ->setColor()
                            ->setType(VuetifyButtonTypes::BLOCK)
                            ->setTitle(trans('modal.verify.verify'))
                            ->setAction(
                                VuexAction::create()->dispatch('user/guest/login', 'OTP')
                            )->setDefault()
                    )
                    ->addFooterButton(
                        ButtonComponent::create()
                            ->setSize(VuetifySizeTypes::X_SMALL)
                            ->setType(VuetifyButtonTypes::BLOCK)
                            ->setColor(VuetifyColors::TRANSPARENT)
                            ->setTitle(trans('modal.use.recovery.code'))
                            ->setAction(
                                ChainAction::create()
                                    ->addAction(
                                        RequestAction::create()
                                            ->get(route('admin.recovery.code'))
                                            ->setOnSuccessAsClosePopupModal($modal->getIdentifier())
                                    )->addAction(
                                        VuexAction::create()->commit('user/guest/oneTimePasswordForm/setData', [])
                                    )
                            )
                    )
            );
    }
}
