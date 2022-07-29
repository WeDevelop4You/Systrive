<?php

namespace Support\Helpers\Deploy\Git\Abstracts;

use Domain\Git\Enums\GitServiceTypes;
use Domain\Git\Mappings\GitAccountTableMap;
use Domain\Git\Models\GitAccount;
use Github\Client as GithubClient;
use Gitlab\Client as GitlabClient;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

abstract class AbstractGit
{
    /**
     * @var GitAccount
     */
    protected GitAccount $account;

    /**
     * @var GithubClient|GitlabClient
     */
    protected GithubClient|GitlabClient $client;

    /**
     * AbstractGit constructor.
     *
     * @throws ModelNotFoundException
     */
    public function __construct()
    {
        /** @var GitAccount $account */
        $account = Auth::user()
            ->gitAccounts()
            ->where(GitAccountTableMap::SERVICE, $this->getService())
            ->firstOrFail();

        $this->account = $account;
        $this->client = $this->setClient();
    }

    abstract public function getService(): GitServiceTypes;

    abstract protected function setClient(): GithubClient|GitlabClient;
}
