<?php

namespace Support\Helpers\Deploy\Git;

use Domain\Git\Enums\GitServiceTypes;
use Support\Helpers\Deploy\Git\Abstracts\AbstractGitService;
use Support\Helpers\Deploy\Git\Github\GithubService;
use Support\Helpers\Deploy\Git\Gitlab\GitlabService;

class Git
{
    public static function service(GitServiceTypes $type): AbstractGitService
    {
        return match ($type) {
            GitServiceTypes::GITHUB => new GithubService(),
            GitServiceTypes::GITLAB => new GitlabService(),
        };
    }
}
