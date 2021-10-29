<?php

namespace Support\Middleware;

use Browser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BotDetection
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->routeIs('admin.bot.detection') && App::isProduction() && Browser::detect()->isBot()) {
            return redirect()->route('admin.bot.detection');
        }

        return $next($request);
    }
}
