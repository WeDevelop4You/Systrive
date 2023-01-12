<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;

class CustomComponent extends Component
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'CustomComponent';
    }

    public function setType(string $type): CustomComponent
    {
        return $this->setData('type', $type);
    }

    public function setAttribute(string $name, mixed $value): static
    {
        return parent::setAttribute($name, $value);
    }

    public function setData(string $key, mixed $value, bool $isArray = false): static
    {
        return parent::setData($key, $value, $isArray);
    }

    public function setContent(string $name, mixed $value): static
    {
        return parent::setContent($name, $value);
    }
}
