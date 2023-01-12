<?php

namespace App\Company\Git\Controllers;

use Domain\Git\Enums\GitServiceTypes;
use Illuminate\Http\JsonResponse;
use Support\Client\Response;
use Support\Helpers\Deploy\Git\Git;

class GitRepositoryController
{
    /**
     * @param GitServiceTypes $service
     *
     * @return JsonResponse
     */
    public function index(GitServiceTypes $service): JsonResponse
    {
        return Response::create()
            ->addData(Git::service($service)->repository()->all())
            ->toJson();
    }
}
