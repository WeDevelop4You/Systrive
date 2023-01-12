<?php

namespace Support\Client\Components\Attributes;

use BadMethodCallException;
use Illuminate\Support\Reflector;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait ComponentWithIfStatement
{
    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return static
     */
    public function __call(string $name, array $arguments): static
    {
        $method = [$this, Str::before($name, 'If')];

        if (Reflector::isCallable($method)) {
            if (\is_bool($arguments[0]) && isset($arguments[1])) {
                return $arguments[0] ? \call_user_func_array($method, \array_slice($arguments, 1)) : $this;
            }

            throw new InvalidArgumentException();
        }

        throw new BadMethodCallException();
    }
}
