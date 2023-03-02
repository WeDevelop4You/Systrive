<?php

namespace Support\Middleware;

use Closure;
use Domain\Api\Enums\ApiAccessTokenRestrictionType;
use Domain\Api\Models\ApiAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class EnsureApiRequestsAreStateful
{
    public function handle(Request $request, Closure $next)
    {
        if ($this->isStateful($request)) {
            return $next($request);
        }

        abort(Response::json(['message' => 'forbidden'], 403));
    }

    private function isStateful(Request $request): bool
    {
        $token = ApiAccessToken::findToken($request->bearerToken());

        return match ($token->restriction) {
            ApiAccessTokenRestrictionType::IP => $this->checkIp($request, $token->stateful ?: []),
            ApiAccessTokenRestrictionType::DOMAIN => $this->checkDomain($request, $token->stateful ?: []),
            ApiAccessTokenRestrictionType::NONE => true,
        };
    }

    private function checkDomain(Request $request, array $stateful): bool
    {
        $domain = $request->headers->get('referer', $request->headers->get('origin'));

        if (is_null($domain)) {
            return false;
        }

        Str::of($domain)
            ->replaceFirst('https://', '')
            ->replaceFirst('http://', '')
            ->finish('/')
            ->is(Collection::make($stateful)->map(function ($uri) {
                return trim($uri).'/*';
            })->all());
    }

    private function checkIp(Request $request, array $stateful): bool
    {
        $ip = $request->headers->get('x-forward-for', $request->ip());

        if (is_null($ip)) {
            return false;
        }

        return Str::is($stateful, $ip);
    }
}
