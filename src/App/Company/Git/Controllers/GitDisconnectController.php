<?php

namespace App\Company\Git\Controllers;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;

class GitDisconnectController
{
    /**
     * @param GitServiceTypes $service
     *
     * @return JsonResponse
     */
    public function action(GitServiceTypes $service): JsonResponse
    {
        Auth::user()->gitAccounts()->where(GitAccountTableMap::COL_SERVICE, $service)->delete();

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.success.git.disconnect'))
            )
            ->toJson();
    }
}
