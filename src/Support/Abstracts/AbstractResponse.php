<?php

namespace Support\Abstracts;

use Support\Client\Response;

abstract class AbstractResponse
{
    /**
     * @param ...$arguments
     *
     * @return Response
     */
    public static function create(...$arguments): Response
    {
        $instance = new static(...$arguments);

        return $instance->handle();
    }

    /**
     * @return Response
     */
    abstract protected function handle(): Response;
}
