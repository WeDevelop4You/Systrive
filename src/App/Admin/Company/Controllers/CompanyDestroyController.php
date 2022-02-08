<?php

    namespace App\Admin\Company\Controllers;

    use Domain\Company\Models\Company;
    use Illuminate\Http\JsonResponse;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;

    class CompanyDestroyController
    {
        /**
         * @param Company $company
         *
         * @return JsonResponse
         */
        public function action(Company $company): JsonResponse
        {
            $company->delete();

            return Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.deleted')))
                ->toJson();
        }
    }
