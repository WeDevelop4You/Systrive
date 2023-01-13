<?php

namespace Support\Client\Components\Forms\Utils\Logics;

use Illuminate\Support\Arr;

class Contain extends AbstractLogic
{
    /**
     * Contain constructor
     *
     * @param string $key
     * @param bool   $condition
     */
    public function __construct(string $key, bool $condition = true)
    {
        parent::__construct($key);

        $this->setData('condition', $condition);
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'contain';
    }

    /**
     * @param ...$values
     *
     * @return $this
     */
    public function setValues(...$values): static
    {
        return $this->setData('values', Arr::flatten($values));
    }
}
