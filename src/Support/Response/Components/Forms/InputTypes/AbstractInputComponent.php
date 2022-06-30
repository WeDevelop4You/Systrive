<?php

namespace Support\Response\Components\Forms\InputTypes;

use Support\Response\Components\AbstractComponent;

abstract class AbstractInputComponent extends AbstractComponent
{
    /**
     * AbstractInputComponent constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setAttribute('dense', true);
        $this->setAttribute('outlined', true);
    }

    /**
     * @param string $label
     *
     * @return static
     */
    public function setLabel(string $label): static
    {
        return $this->setContent('label', $label);
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function setValue(mixed $value): static
    {
        return $this->setContent('value', $value);
    }

    /**
     * @param bool|string $autoHide
     *
     * @return static
     */
    public function setHideDetails(bool|string $autoHide = true): static
    {
        return $this->setAttribute('hide-details', $autoHide);
    }

    /**
     * @param string $styling
     *
     * @return static
     */
    public function setAdditionalStyling(string $styling): static
    {
        return $this->setAttribute('style', $styling);
    }

    /**
     * @param string $key
     *
     * @return static
     */
    public function setKey(string $key): static
    {
        return $this->setData('key', $key);
    }

    /**
     * @param string $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        return $this->setData('vuexNamespace', $vuexNamespace);
    }

    /**
     * @return static
     */
    public function setDisabledOnLoading(): static
    {
        return $this->setData('disabledOnLoading', true);
    }
}
