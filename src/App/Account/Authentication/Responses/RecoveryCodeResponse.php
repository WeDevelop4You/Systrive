<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\RecoveryCodeForm;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Popups\Modals\FormModal;
use Support\Client\Response;
use Support\Enums\Component\Vuetify\VuetifyButtonType;

class RecoveryCodeResponse extends AbstractResponse
{
    /**
     * {@inheritDoc}
     */
    protected function handle(): Response
    {
        $modal = FormModal::create('guest/login/form');

        $modal->getModal()
            ->setCloseAction(
                VuexAction::create()->commit('guest/login/reset')
            );

        return Response::create()
            ->addPopup(
                $modal->setWidth(323)
                    ->setTitle(trans('modal.recovery.code'))
                    ->setForm(RecoveryCodeForm::create())
                    ->addFooter(
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('modal.verify.verify'))
                            ->setType(VuetifyButtonType::BLOCK)
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'guest/login/send',
                                    route('account.login.rc')
                                )
                            )
                    )
            );
    }
}
