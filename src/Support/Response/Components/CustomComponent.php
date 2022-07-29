<?php

namespace Support\Response\Components;

class CustomComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Custom';
    }

    public function setType(string $type): CustomComponent
    {
        return $this->setData('type', $type);
    }

    public function setAttribute(string $name, mixed $value): static
    {
        return parent::setAttribute($name, $value);
    }

    public function setData(string $name, mixed $value, bool $isArray = false): static
    {
        return parent::setData($name, $value, $isArray);
    }

    public function setContent(string $name, mixed $value): static
    {
        return parent::setContent($name, $value);
    }
}
