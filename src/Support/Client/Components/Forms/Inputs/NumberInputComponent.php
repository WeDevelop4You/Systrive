<?php

namespace Support\Client\Components\Forms\Inputs;

class NumberInputComponent extends AbstractInputComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'NumberInputComponent';
    }

    /**
     * @param int $total
     * @param int $places
     *
     * @return $this
     */
    public function setNumeric(int $total = 8, int $places = 2): static
    {
        return $this->setData('isNumeric', true)
            ->setData('total', $total - $places)
            ->setData('places', $places);
    }
}
