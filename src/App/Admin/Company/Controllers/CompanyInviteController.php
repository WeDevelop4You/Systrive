<?php

    namespace App\Admin\Company\Controllers;

    use App\Admin\Company\Requests\CompanyCreateRequest;
    use Domain\Company\Actions\CreateCompanyAction;
    use Domain\Company\Models\Company;
    use Domain\Invite\Actions\InviteTokenAction;
    use Domain\Invite\Actions\ValidateInviteTokenAction;
    use Domain\Invite\DataTransferObject\CompanyInviteData;
    use Domain\Invite\DataTransferObject\InviteData;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Support\Exceptions\InvalidTokenException;
    use Support\Exceptions\InviteNewUserException;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use Symfony\Component\HttpFoundation\Response as ResponseCodes;

    class CompanyInviteController
    {
        /**
         * @param Company $company
         * @param string  $token
         * @param string  $encryptEmail
         *
         * @return RedirectResponse
         */
        public function index(Company $company, string $token, string $encryptEmail): RedirectResponse
        {
            try {
                $invite = (new ValidateInviteTokenAction())(new InviteData($company->id, $token, $encryptEmail));

                (new InviteTokenAction($token, $encryptEmail))($invite);
            } catch (InviteNewUserException) {
                return redirect()->route('admin.web.registration');
            } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                Response::create()
                    ->addPopup(new SimpleNotification(trans('response.error.invalid.token')))
                    ->setStatusCode(ResponseCodes::HTTP_BAD_REQUEST)
                    ->toSession();
            }

            return redirect()->route('admin.dashboard');
        }

        /**
         * @param CompanyCreateRequest $requests
         *
         * @return JsonResponse
         */
        public function action(CompanyCreateRequest $requests): JsonResponse
        {
            $data = new CompanyInviteData(...$requests->validated());

            (new CreateCompanyAction())($data);

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.saved')))
                ->setStatusCode(ResponseCodes::HTTP_CREATED)
                ->toJson();
        }
    }
