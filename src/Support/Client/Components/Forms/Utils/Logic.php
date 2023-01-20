<?php

namespace Support\Client\Components\Forms\Utils;

use Support\Client\Components\Forms\Utils\Logics\Condition;
use Support\Client\Components\Forms\Utils\Logics\Contain;
use Support\Client\Components\Forms\Utils\Logics\Statement;

class Logic
{
    /**
     * @param string $key
     *
     * @return Contain
     */
    public static function contain(string $key): Contain
    {
        return new Contain($key);
    }

    /**
     * @param string $key
     *
     * @return Contain
     */
    public static function except(string $key): Contain
    {
        return new Contain($key, false);
    }

    /**
     * @param string $key
     *
     * @return Statement
     */
    public static function if(string $key): Statement
    {
        return new Statement($key);
    }

    /**
     * @param string $key
     *
     * @return Statement
     */
    public static function unless(string $key): Statement
    {
        return new Statement($key, false);
    }

    /**
     * @param string $key
     *
     * @return Condition
     */
    public static function condition(string $key): Condition
    {
        return new Condition($key);
    }
}
