<?php

    namespace App\Admin\Company\User\Controllers;

    use Domain\Company\Actions\UserInviteToCompanyAcceptedAction;
    use Domain\Company\Models\Company;
    use Domain\User\Actions\ValidateInviteTokenAction;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Action\Methods\VuexMethod;
    use Support\Helpers\Response\Popups\Modals\ConfirmModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
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
                $userInvite = (new ValidateInviteTokenAction($company, $token))();

                $response->addPopup(
                    ConfirmModal::create()
                    ->setTitle(trans('modal.confirm.accepted.invite.company.title'))
                    ->setText(trans('modal.confirm.accepted.invite.company.text'))
                    ->setAcceptUrl(route('admin.company.user.invite.accepted', [
                        $userInvite->company_id,
                        $token,
                    ]))
                    ->setCancelUrl(route('admin.session.delete', ['key' => Response::SESSION_KEY_MODAL]))
                );
            } catch (ModelNotFoundException | InvalidTokenException) {
                Session::forget(Response::SESSION_KEY_MODAL);

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
                (new ValidateInviteTokenAction($company, $token))();

                (new UserInviteToCompanyAcceptedAction(Auth::user()))($company);

                $response->addPopup(new SimpleNotification(trans('response.success.company.invite.accepted')))
                    ->addAction(VuexMethod::create()->dispatch('navigation/getCompanies', true));
            } catch (ModelNotFoundException | InvalidTokenException) {
                $response->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            Session::forget(Response::SESSION_KEY_MODAL);

            return $response->toJson();
        }
    }
