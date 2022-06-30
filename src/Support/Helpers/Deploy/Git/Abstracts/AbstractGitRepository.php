<?php

namespace Support\Helpers\Deploy\Git\Abstracts;

abstract class AbstractGitRepository extends AbstractGit
{
    /**
     * @return array
     */
    abstract public function all(): array;

    /**
     * @param string $identifier
     *
     * @return array
     */
    abstract public function getBranches(string $identifier): array;
}
