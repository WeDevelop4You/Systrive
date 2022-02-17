<?php

    namespace App\Admin\Authentication\Controllers;

    use Illuminate\Http\JsonResponse;
    use Support\Enums\FormTypes;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Helpers\Response\Action\Methods\VuexMethods;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\FormModal;
    use Support\Helpers\Response\Response;

    class RecoveryCodeController
    {
        /**
         * @return JsonResponse
         */
        public function index(): JsonResponse
        {
            return Response::create()
                ->addPopup(
                    FormModal::create()
                        ->setDismissible()
                        ->setTitle(trans('modal.recovery.code'))
                        ->setFormComponent(FormTypes::RECOVERY_CODE)
                        ->addButton(
                            Button::create()
                                ->setColor()
                                ->setTitle(trans('modal.verify.verify'))
                                ->setType(VuetifyButtonTypes::BLOCK)
                                ->setAction(
                                    VuexMethods::create()->dispatch('guest/login', 'RC')
                                )->setListener()
                        )->setMaxWidth(323)
                )->toJson();
        }
    }
