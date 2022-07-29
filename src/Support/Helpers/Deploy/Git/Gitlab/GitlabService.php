<?php

namespace Support\Helpers\Deploy\Git\Gitlab;

use Support\Helpers\Deploy\Git\Abstracts\AbstractGitRepository;
use Support\Helpers\Deploy\Git\Abstracts\AbstractGitService;

class GitlabService extends AbstractGitService
{
    /**
     * @inheritDoc
     */
    public function repository(): AbstractGitRepository
    {
        return new GitlabRepository();
    }
}
