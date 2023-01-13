<?php

namespace Support\Client\Components\Forms\Utils\Logics;

class Statement extends AbstractLogic
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

        $this->setData('condition', $condition)
            ->setCompressing();
    }

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return 'statement';
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setCompressing(mixed $value = true): static
    {
        return $this->setData('compressing', $value);
    }
}
