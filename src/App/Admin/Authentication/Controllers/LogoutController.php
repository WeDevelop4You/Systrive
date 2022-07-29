<?php

namespace App\Admin\Authentication\Controllers;

use Domain\Authentication\Actions\LogoutAction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Support\Response\Response;

class LogoutController
{
    /**
     * @param Request $request
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function action(Request $request): View|Factory|JsonResponse|Application
    {
        (new LogoutAction())($request);

        return $request->expectsJson()
            ? Response::create()->addRedirect(route('admin.web.login'))->toJson()
            : view('admin::pages.login');
    }
}
