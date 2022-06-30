<?php

namespace App\Admin\Git\Controllers;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Support\Response\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Response\Response;

class GitDisconnectController
{
    /**
     * @param GitServiceTypes $service
     *
     * @return JsonResponse
     */
    public function action(GitServiceTypes $service): JsonResponse
    {
        Auth::user()->gitAccounts()->where(GitAccountTableMap::SERVICE, $service)->delete();

        return Response::create()
            ->addPopup(
                SimpleNotificationComponent::create()
                    ->setText(trans('response.success.git.disconnect'))
            )
            ->toJson();
    }
}
