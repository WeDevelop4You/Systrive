<?php

namespace Support\Response\Components\Forms\Inputs;

use Support\Response\Components\AbstractComponent;

abstract class AbstractInputComponent extends AbstractComponent
{
    /**
     * AbstractInputComponent constructor.
     */
    protected function __construct()
    {
        parent::__construct();

        $this->setHideDetails('auto');
        $this->setAttribute('dense', true);
        $this->setAttribute('outlined', true);
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel(string $label): static
    {
        return $this->setContent('label', $label);
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        return $this->setContent('value', $value);
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setDefaultValue(mixed $value): static
    {
        return $this->setContent('defaultValue', $value);
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setHint(string $text): static
    {
        return $this->setAttribute('hint', $text)
            ->setAttribute('persistent-hint', true);
    }

    /**
     * @param bool   $condition
     * @param string $text
     *
     * @return $this
     */
    public function setHintIf(bool $condition, string $text): static
    {
        if ($condition) {
            $this->setHint($text);
        }

        return $this;
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setClearable(bool $condition = true): static
    {
        return $this->setAttribute('clearable', $condition);
    }

    /**
     * @return $this
     */
    public function setReadonly(bool $condition = true): static
    {
        return $this->setAttribute('readonly', $condition);
    }

    /**
     * @param bool|string $autoHide
     *
     * @return $this
     */
    public function setHideDetails(bool|string $autoHide = true): static
    {
        return $this->setAttribute('hide-details', $autoHide);
    }

    /**
     * @param string $styling
     *
     * @return $this
     */
    public function setAdditionalStyling(string $styling): static
    {
        return $this->setAttribute('style', $styling);
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): static
    {
        return $this->setData('key', $key);
    }

    /**
     * @param string $vuexNamespace
     *
     * @return $this
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        return $this->setData('vuexNamespace', $vuexNamespace);
    }

    /**
     * @return $this
     */
    public function setDisabledOnLoading(): static
    {
        return $this->setData('disabledOnLoading', true);
    }
}
