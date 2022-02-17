<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyCompleteRequest;
    use Domain\Company\Actions\CompleteCompanyAction;
    use Domain\Company\DataTransferObjects\CompleteCompanyData;
    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\InviteData;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Session;
    use Support\Enums\FormTypes;
    use Support\Enums\SessionKeyTypes;
    use Support\Enums\Vuetify\VuetifyButtonTypes;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Action\Methods\RequestMethods;
    use Support\Helpers\Response\Popups\Components\Button;
    use Support\Helpers\Response\Popups\Modals\FormModal;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class CompanyCreateController
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
                    FormModal::create()
                        ->setFormComponent(FormTypes::COMPANY)
                        ->setTitle(translateToVuetify('word.company.complete'))
                        ->addButton(
                            Button::create()
                                ->setTitle(trans('modal.cancel.cancel'))
                                ->setType(VuetifyButtonTypes::TEXT)
                                ->setAction(
                                    RequestMethods::create()
                                        ->patch(route('admin.company.complete', [$company->id, $token]))
                                )
                        )->addButton(
                            Button::create()
                                ->setTitle(trans('modal.save.save'))
                                ->setColor()
                                ->setAction(
                                    RequestMethods::create()
                                        ->delete(route('admin.session.delete', ['key' => SessionKeyTypes::KEEP->value]))
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
         * @param CompanyCompleteRequest $request
         * @param Company                $company
         * @param string                 $token
         *
         * @return JsonResponse
         */
        public function action(CompanyCompleteRequest $request, Company $company, string $token): JsonResponse
        {
            $response = new Response();

            try {
                (new ValidateInviteTokenAction())(new InviteData($company->id, $token));

                $data = new CompleteCompanyData(...$request->validated());

                (new CompleteCompanyAction($company))($data);

                $response->addPopup(new SimpleNotification(trans('response.success.company.complete')));
            } catch (ModelNotFoundException | InvalidTokenException) {
                Session::forget(SessionKeyTypes::KEEP->value);

                $response->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST);
            }

            return $response->toJson();
        }
    }
