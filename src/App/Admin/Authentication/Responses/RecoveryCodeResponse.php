<?php

namespace App\Admin\Authentication\Responses;

use Support\Abstracts\AbstractResponse;
use Support\Enums\FormTypes;
use Support\Enums\Vuetify\VuetifyButtonTypes;
use Support\Response\Actions\VuexAction;
use Support\Response\Components\Buttons\ButtonComponent;
use Support\Response\Components\Forms\CustomFormComponent;
use Support\Response\Components\Popups\Modals\FormModal;
use Support\Response\Response;

class RecoveryCodeResponse extends AbstractResponse
{
    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        $modal = FormModal::create('user/guest/recoveryCodeForm');

        $modal->getModal()
            ->setCloseAction(
                VuexAction::create()->commit('user/guest/recoveryCodeForm/setData', [])
            );

        return Response::create()
            ->addPopup(
                $modal->setWidth(323)
                    ->setTitle(trans('modal.recovery.code'))
                    ->setForm(
                        CustomFormComponent::create()->setType(FormTypes::RECOVERY_CODE)
                    )
                    ->addFooterButton(
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('modal.verify.verify'))
                            ->setType(VuetifyButtonTypes::BLOCK)
                            ->setAction(
                                VuexAction::create()->dispatch('user/guest/login', 'RC')
                            )->setDefault()
                    )
            );
    }
}
