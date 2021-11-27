<?php

    namespace App\Admin\Company\User\Controllers;

    use App\Admin\Company\User\Requests\CompanyUserInviteRequest;
    use Domain\Company\Actions\InviteUserToCompanyAction;
    use Domain\Company\DataTransferObjects\CompanyUserData;
    use Domain\Company\Models\Company;
    use Domain\User\Actions\ValidateInviteTokenAction;
    use Illuminate\Contracts\Encryption\DecryptException;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Session;
    use Support\Exceptions\InvalidTokenException;
    use Support\Helpers\Response\Action\Methods\ConfirmPopupMethod;
    use Support\Helpers\Response\Response;

    class CompanyUserInviteController
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
            $responseData = new Response();

            try {
                $check = (new ValidateInviteTokenAction($company, $token, $encryptEmail))();

                if ($check) {
                    return redirect()->route('admin.register', [$company->id, $token, $encryptEmail]);
                } else {
                    $responseData->addAction(ConfirmPopupMethod::create());

                    Session::put('responseDataConfirm', $responseData->createResponseContent());

                    return redirect()->route('admin.dashboard');
                }
            } catch (DecryptException | ModelNotFoundException | InvalidTokenException) {
                $responseData->addPopup(trans('response.error.invalid.token'));

                Session::put('responseData', $responseData->createResponseContent());
            }

            return redirect()->route('admin.login');
        }

        /**
         * @param CompanyUserInviteRequest $request
         * @param Company                  $company
         */
        public function action(CompanyUserInviteRequest $request, Company $company)
        {
            $data = new CompanyUserData(...$request->validated());

            (new InviteUserToCompanyAction($company))($data);
        }
    }
