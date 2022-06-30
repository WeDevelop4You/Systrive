<?php

namespace App\Admin\Git\Controllers;

use Domain\Git\Enums\GitServiceTypes;
use Illuminate\Http\JsonResponse;
use Support\Helpers\Deploy\Git\Git;
use Support\Response\Response;

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
