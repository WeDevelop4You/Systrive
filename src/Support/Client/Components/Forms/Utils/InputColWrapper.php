<?php

namespace Support\Client\Components\Forms\Utils;

use Support\Client\Components\Forms\Inputs\AbstractInputComponent;
use Support\Client\Components\Forms\Inputs\ConditionInputComponent;
use Support\Client\Components\Layouts\ColComponent;

class InputColWrapper
{
    private bool $condition = true;

    /**
     * @var ColComponent
     */
    private ColComponent $col;

    /**
     * @var AbstractInputComponent|ConditionInputComponent
     */
    private AbstractInputComponent|ConditionInputComponent $input;

    /**
     * InputColHelper constructor.
     */
    private function __construct()
    {
        $this->setCol(ColComponent::create());
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static();
    }

    /**
     * @return bool
     */
    public function getCondition(): bool
    {
        return $this->condition;
    }

    /**
     * @param bool $condition
     *
     * @return InputColWrapper
     */
    public function setCondition(bool $condition = false): InputColWrapper
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * @param ColComponent $col
     *
     * @return InputColWrapper
     */
    public function setCol(ColComponent $col): InputColWrapper
    {
        $this->col = $col;

        return $this;
    }

    /**
     * @param AbstractInputComponent|ConditionInputComponent $input
     *
     * @return InputColWrapper
     */
    public function setInput(AbstractInputComponent|ConditionInputComponent $input): InputColWrapper
    {
        $this->input = $input;

        return $this;
    }

    public function export(?string $vuexNamespace = null): ColComponent
    {
        if (! \is_null($vuexNamespace) && $this->input instanceof AbstractInputComponent) {
            $this->input->setVuexNamespace($vuexNamespace);
        }

        return $this->col->setComponent($this->input);
    }
}
