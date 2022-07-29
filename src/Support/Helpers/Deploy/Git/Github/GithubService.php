<?php

namespace Support\Helpers\Deploy\Git\Github;

use Support\Helpers\Deploy\Git\Abstracts\AbstractGitService;

class GithubService extends AbstractGitService
{
    public function repository(): GithubRepository
    {
        return new GithubRepository();
    }
}
