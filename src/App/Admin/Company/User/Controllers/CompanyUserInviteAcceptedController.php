<?php

    namespace App\Admin\Company\User\Controllers;

    use Domain\Company\Actions\User\UserInviteToCompanyAcceptedAction;
    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Enums\RequestMethodTypes;
    use Support\Enums\SessionKeyTypes;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Enums\Vuetify\VuetifyColors;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Action\Methods\RequestMethods;
    use Support\Helpers\Response\Action\Methods\VuexMethods;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\ConfirmModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Support\Helpers\VuetifyHelper;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class CompanyUserInviteAcceptedController
    {
        /**
         * @param Company $company
         * @param string  $token
         *
         * @return JsonResponse
         */
        public function index(Company $company, string $token): JsonResponse
        {
            $response = new Response();

            try {
                (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

                $response->addPopup(
                    ConfirmModal::create()
                        ->setTitle(trans('modal.confirm.accepted.invite.company.title'))
                        ->setText(trans('modal.confirm.accepted.invite.company.text'))
                        ->addButton(
                            Button::create()
                                ->setTitle(trans('modal.confirm.cancel.cancel'))
                                ->setType(VuetifyButtonTypes::TEXT)
                                ->setAction(
                                    RequestMethods::create()
                                        ->delete(route('admin.session.delete', ['key' => SessionKeyTypes::KEEP->value]))
                                )
                        )->addButton(
                            Button::create()
                                ->setTitle(trans('modal.confirm.accept.accept'))
                                ->setColor()
                                ->setAction(
                                    RequestMethods::create()
                                        ->post(route('admin.company.user.invite.accepted', [$company->id, $token]))
                                )
                        )
                );
            } catch (ModelNotFoundException | InvalidTokenException) {
                Session::forget(SessionKeyTypes::KEEP->value);

                $response->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            return $response->toJson();
        }

        /**
         * @param Company $company
         * @param string  $token
         *
         * @return JsonResponse
         */
        public function action(Company $company, string $token): JsonResponse
        {
            $response = new Response();

            try {
                (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

                (new UserInviteToCompanyAcceptedAction(Auth::user()))($company);

                $response->addPopup(new SimpleNotification(trans('response.success.company.invite.accepted')))
                    ->addAction(VuexMethods::create()->dispatch('navigation/getCompanies'));
            } catch (ModelNotFoundException | InvalidTokenException) {
                $response->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            Session::forget(SessionKeyTypes::KEEP->value);

            return $response->toJson();
        }
    }
