<?php

namespace Domain\Authentication\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

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
            ->addPopup(SimpleNotificationComponent::create()->setText(trans('response.success.logout')))
            ->toSession();
    }
}
