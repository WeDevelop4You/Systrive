<?php

namespace App\Account\Authentication\Responses;

use App\Account\Authentication\Forms\AcceptForm;
use App\Account\Authentication\Forms\PasswordForm;
use App\Account\Authentication\Forms\ProfileForm;
use Domain\Invite\Models\Invite;
use Support\Abstracts\AbstractResponse;
use Support\Client\Actions\RouteAction;
use Support\Client\Actions\VuexAction;
use Support\Client\Components\Buttons\ButtonComponent;
use Support\Client\Components\Buttons\MultipleButtonComponent;
use Support\Client\Components\Misc\CustomComponent;
use Support\Client\Components\Navbar\Helpers\VueRouteHelper;
use Support\Client\Components\Overviews\Steppers\StepperItemComponent;
use Support\Client\Components\Overviews\Steppers\VerticalStepperComponent;
use Support\Client\Response;

class RegistrationResponse extends AbstractResponse
{
    /**
     * RegistrationResponse constructor.
     *
     * @param Invite $invite
     */
    protected function __construct(
        private readonly Invite $invite
    ) {
        //
    }

    /**
     * @inheritDoc
     */
    protected function handle(): Response
    {
        return Response::create()
            ->addComponent(
                VerticalStepperComponent::create()
                    ->setWidth(450)
                    ->setVuexNamespace('guest/registration/stepper')
                    ->setHeader(
                        CustomComponent::create()
                            ->setType('LogoCardHeaderComponent')
                            ->setContent('title', trans('word.registration.registration'))
                    )
                    ->setItems([
                        $this->createPasswordStepperItem(),
                        $this->createProfileStepperItem(),
                        $this->createAcceptStepperItem(),
                    ])
            );
    }

    /**
     * @return StepperItemComponent
     */
    private function createPasswordStepperItem(): StepperItemComponent
    {
        return StepperItemComponent::create()
            ->setTitle(trans('word.password.password'))
            ->setComponents([
                CustomComponent::create()
                    ->setType('PasswordRequirementsComponent')
                    ->setData('vuexNamespace', 'guest/registration/password'),
                PasswordForm::create($this->invite->user)->setVuexNamespace('guest/registration/form'),
                MultipleButtonComponent::create()
                    ->setClass('gap-3')
                    ->setButtons([
                        ButtonComponent::create()
                            ->setType()
                            ->setTitle(trans('word.cancel.cancel'))
                            ->setAction(
                                RouteAction::create()->goTo(VueRouteHelper::create()->setName('login'))
                            ),
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.next.next'))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'guest/registration/nextProfile',
                                    route('account.registration.validation.password')
                                )
                            ),
                    ]),
            ]);
    }

    /**
     * @return StepperItemComponent
     */
    private function createProfileStepperItem(): StepperItemComponent
    {
        return StepperItemComponent::create()
            ->setTitle(trans('word.profile.profile'))
            ->setComponents([
                ProfileForm::create()->setVuexNamespace('guest/registration/form'),
                MultipleButtonComponent::create()
                    ->setClass('gap-3')
                    ->setButtons([
                        ButtonComponent::create()
                            ->setType()
                            ->setTitle(trans('word.back.back'))
                            ->setAction(
                                VuexAction::create()->commit(
                                    'guest/registration/stepper/back'
                                )
                            ),
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.next.next'))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'guest/registration/nextAccept',
                                    route('account.registration.validation.profile')
                                )
                            ),
                    ]),
            ]);
    }

    /**
     * @return StepperItemComponent
     */
    private function createAcceptStepperItem(): StepperItemComponent
    {
        return StepperItemComponent::create()
            ->setTitle(trans('word.accept.accept'))
            ->setComponents([
                AcceptForm::create()->setVuexNamespace('guest/registration/form'),
                MultipleButtonComponent::create()
                    ->setClass('gap-3')
                    ->setButtons([
                        ButtonComponent::create()
                            ->setType()
                            ->setTitle(trans('word.back.back'))
                            ->setAction(
                                VuexAction::create()->commit(
                                    'guest/registration/stepper/back'
                                )
                            ),
                        ButtonComponent::create()
                            ->setColor()
                            ->setTitle(trans('word.accept.accept'))
                            ->setAction(
                                VuexAction::create()->dispatch(
                                    'guest/registration/send',
                                    route('account.registration')
                                )
                            ),
                    ]),
            ]);
    }
}
