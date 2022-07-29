<?php

namespace App\Admin\Account\Controllers;

use App\Admin\Account\Resources\AccountPreferenceResource;
use Domain\User\Enums\UserPreferences;
use Domain\User\Mappings\UserProfileTableMap;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as NoContentResponse;
use Illuminate\Support\Facades\Auth;
use Support\Response\Response;

class AccountPreferenceController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Response::create()
            ->addData(AccountPreferenceResource::make(Auth::user()))
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
                UserProfileTableMap::PREFERENCES => $performances,
            ]);

        return response()->noContent();
    }
}
