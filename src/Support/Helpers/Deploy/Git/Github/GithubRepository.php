<?php

namespace Support\Helpers\Deploy\Git\Github;

use Domain\Git\Enums\GitServiceTypes;
use Github\Client;
use Github\ResultPager;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Support\Helpers\Deploy\Git\Abstracts\AbstractGitRepository;

class GithubRepository extends AbstractGitRepository
{
    public function getService(): GitServiceTypes
    {
        return GitServiceTypes::GITHUB;
    }

    protected function setClient(): Client
    {
        return GitHub::getFactory()
            ->make([
                'method' => 'token',
                'token' => $this->account->accessToken->token,
            ]);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        $pager = new ResultPager($this->client);

        $repositories = $pager->fetchAll(
            $this->client->currentUser(),
            'repositories',
            ['all']
        );

        return Collection::make($repositories)->map(function (array $repositories) {
            $fullName = Arr::get($repositories, 'full_name');

            return [
                'text' => $fullName,
                'value' => $fullName,
            ];
        })->toArray();
    }

    /**
     * @param string $identifier
     *
     * @return array
     */
    public function getBranches(string $identifier): array
    {
        [$username, $repository] = explode('/', $identifier);

        $pager = new ResultPager($this->client);

        $branches = $pager->fetchAll(
            $this->client->repository(),
            'branches',
            [$username, $repository]
        );

        return Collection::make($branches)->map(function (array $repositories) {
            $name = Arr::get($repositories, 'name');

            return [
                'text' => $name,
                'value' => $name,
            ];
        })->toArray();
    }
}
