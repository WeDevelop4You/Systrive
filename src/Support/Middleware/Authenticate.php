<?php

namespace Support\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Support\Helpers\ApplicationHelper;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson() || ApplicationHelper::isApiDomain()) {
            abort(Response::json(['message' => 'unauthorized'], 401));
        }

        return route('account.view.auth');
    }
}
