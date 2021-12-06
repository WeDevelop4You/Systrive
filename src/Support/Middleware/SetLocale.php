<?php

namespace Support\Middleware;

use Closure;
use Domain\Company\Models\Company;
use Domain\User\Models\UserInvite;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Support\Helpers\Response\Popups\Notifications\SimpleNotification;
use Support\Helpers\Response\Response;
use Symfony\Component\HttpFoundation\Response as ResponseCodes;

class SetLocale
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $locale = Auth::user()->locale;
        } else {
            $locale = Session::get('locale', App::getFallbackLocale());
        }

        App::setLocale($locale);

        return $next($request);
    }
}
