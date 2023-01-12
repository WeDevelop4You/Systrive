<?php

namespace App\Company\Git\Controllers;

use Domain\Git\Enums\GitServiceTypes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Support\Client\Components\Popups\Notifications\SimpleNotificationComponent;
use Support\Client\Response;
use Support\Helpers\Deploy\Git\Git;

class GitRepositoryBranchController
{
    /**
     * @param Request         $request
     * @param GitServiceTypes $service
     *
     * @return JsonResponse
     */
    public function index(Request $request, GitServiceTypes $service): JsonResponse
    {
        $response = Response::create();
        $identifier = $request->query('identifier');

        if (\is_null($identifier)) {
            $response->addPopup(SimpleNotificationComponent::create()->setText(trans('response.error.git.repository.identifier')));
        } else {
            $response->addData(Git::service($service)->repository()->getBranches($identifier));
        }

        return $response->toJson();
    }
}
