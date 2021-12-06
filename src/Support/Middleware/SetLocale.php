<?php

namespace Support\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
