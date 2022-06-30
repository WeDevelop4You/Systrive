<?php

namespace Support\Helpers\Deploy\Git\Gitlab;

use Domain\Git\Enums\GitServiceTypes;
use Gitlab\Client;
use Gitlab\ResultPager;
use GrahamCampbell\GitLab\Facades\GitLab;
use Http\Client\Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Support\Helpers\Deploy\Git\Abstracts\AbstractGitRepository;

class GitlabRepository extends AbstractGitRepository
{
    public function getService(): GitServiceTypes
    {
        return GitServiceTypes::GITLAB;
    }

    /**
     * @return Client
     */
    public function setClient(): Client
    {
        return GitLab::getFactory()
            ->make([
                'method' => 'oauth',
                'token' => $this->account->accessToken->token,
            ]);
    }

    /**
     * @throws Exception
     *
     * @return array
     */
    public function all(): array
    {
        $pager = new ResultPager($this->client);

        $repositories = $pager->fetchAll(
            $this->client->projects(),
            'all',
            ['parameters' => ['simple' => true, 'membership' => true]]
        );

        return Collection::make($repositories)->map(function (array $repositories) {
            return [
                'text' => Arr::get($repositories, 'id'),
                'value' => Arr::get($repositories, 'path_with_namespace'),
            ];
        })->toArray();
    }

    /**
     * @param string $identifier
     *
     * @throws Exception
     *
     * @return array
     */
    public function getBranches(string $identifier): array
    {
        $pager = new ResultPager($this->client);

        $branches = $pager->fetchAll(
            $this->client->repositories(),
            'branches',
            [$identifier]
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
