<?php

namespace Support\Helpers\Deploy\Git\Abstracts;

abstract class AbstractGitService
{
    /**
     * @return AbstractGitRepository
     */
    abstract public function repository(): AbstractGitRepository;
}
