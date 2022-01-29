<?php

    namespace Domain\Authentication\Actions;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
    use Support\Helpers\Response\Response;
    use function trans;

    class LogoutAction
    {
        /**
         * @param Request $request
         *
         * @return void
         */
        public function __invoke(Request $request): void
        {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            Response::create()
                ->addPopup(new SimpleNotification(trans('response.success.logout')))
                ->toSession();
        }
    }
