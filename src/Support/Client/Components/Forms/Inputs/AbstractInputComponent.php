<?php

namespace Support\Client\Components\Forms\Inputs;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Attributes\ComponentWithIfStatement;
use Support\Client\Components\Component;
use Support\Client\Components\Forms\Utils\Logic;
use Support\Helpers\VuexNamespaceHelper;

/**
 * @method setHintIf(bool $condition, string $text, bool $withInput = false)
 */
abstract class AbstractInputComponent extends Component
{
    use ComponentWithClasses, ComponentWithIfStatement;

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
     * @param string $key
     *
     * @return $this
     */
    public function setKey(string $key): static
    {
        return $this->setData('key', $key);
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function setErrorKey(string $key): static
    {
        return $this->setData('errorKey', $key);
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
     * @param string|VuexNamespaceHelper $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string|VuexNamespaceHelper $vuexNamespace): static
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData('vuexNamespace', $value);
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
     * @param string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder(string $placeholder): static
    {
        return $this->setAttribute('placeholder', $placeholder);
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setPersistentPlaceholder(bool $condition = true): static
    {
        return $this->setAttribute('persistent-placeholder', $condition);
    }

    /**
     * @param string $text
     * @param bool   $withInput
     *
     * @return $this
     */
    public function setHint(string $text, bool $withInput = false): static
    {
        return $this->setAttribute('hint', $text)
            ->setData('hintWithInput', $withInput)
            ->setAttribute('persistent-hint', true);
    }

    /**
     * @param bool $condition
     *
     * @return AbstractInputComponent
     */
    public function setError(bool $condition = true): AbstractInputComponent
    {
        return $this->setData('error', $condition);
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setAutofocus(bool $condition = true): static
    {
        return $this->setAttribute('autofocus', $condition);
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
     * @param bool $condition
     *
     * @return $this
     */
    public function setReadonly(bool $condition = true): static
    {
        return $this->setAttribute('readonly', $condition);
    }

    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function setDisabled(bool $condition = true): static
    {
        return $this->setData('disabled', $condition);
    }

    /**
     * @param bool|Logic|string $condition
     *
     * @return $this
     */
    public function setHideDetails(bool|string|Logic $condition = true): static
    {
        $value = optional($condition)->export() ?: $condition;

        return $this->setData('hideDetails', $value);
    }

    /**
     * @return $this
     */
    public function setDisabledOnLoading(): static
    {
        return $this->setData('disabledOnLoading', true);
    }

    /**
     * @param Logic $logic
     *
     * @return $this
     */
    public function addHiddenLogic(Logic $logic): static
    {
        return $this->setData('hiddenLogic', $logic->export(), true);
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
}
