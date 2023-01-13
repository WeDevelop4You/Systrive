<?php

namespace Support\Client\Components\Forms\Utils\Logics;

use Illuminate\Support\Arr;

class Condition extends AbstractLogic
{
    /**
     * Contain constructor.
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct($key);

        $this->setTrueValue()
            ->setFalseValue();
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

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setTrueValue(mixed $value = true): static
    {
        return $this->setData('trueValue', $value);
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setFalseValue(mixed $value = false): static
    {
        return $this->setData('falseValue', $value);
    }
}
