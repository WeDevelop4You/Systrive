<?php

namespace App\Account\User\Controllers;

use App\Account\User\Resources\PreferenceResource;
use Domain\User\Enums\UserPreferences;
use Domain\User\Mappings\UserProfileTableMap;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as NoContentResponse;
use Illuminate\Support\Facades\Auth;
use Support\Client\Response;

class UserPreferenceController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Response::create()
            ->addData(PreferenceResource::make(Auth::user()))
            ->toJson();
    }

    /**
     * @param Request $request
     *
     * @return NoContentResponse
     */
    public function action(Request $request): NoContentResponse
    {
        $performances = $request->collect(UserPreferences::values())
            ->filter(function (mixed $value, $key) {
                return UserPreferences::from($key)->validate($value);
            });

        Auth::user()->profile()
            ->update([
                UserProfileTableMap::COL_PREFERENCES => $performances,
            ]);

        return response()->noContent();
    }
}
