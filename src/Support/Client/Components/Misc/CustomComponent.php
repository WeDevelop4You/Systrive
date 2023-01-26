<?php

namespace Support\Client\Components\Misc;

use Support\Client\Components\Component;

class CustomComponent extends Component
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'CustomComponent';
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType(string $type): CustomComponent
    {
        return $this->setData('type', $type);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute(string $key, mixed $value): static
    {
        return parent::setAttribute($key, $value);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @param bool   $isArray
     *
     * @return $this
     */
    public function setData(string $key, mixed $value, bool $isArray = false): static
    {
        return parent::setData($key, $value, $isArray);
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setContent(string $key, mixed $value): static
    {
        return parent::setContent($key, $value);
    }
}
