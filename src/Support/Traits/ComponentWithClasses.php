<?php

namespace Support\Traits;

trait ComponentWithClasses
{
    /**
     * @param array $classes
     *
     * @return static
     */
    public function setClasses(array $classes): static
    {
        foreach ($classes as $class) {
            $this->addClass($class);
        }

        return $this;
    }

    /**
     * @param string $class
     *
     * @return static
     */
    public function addClass(string $class): static
    {
        return $this->setData('classes', $class, true);
    }
}
