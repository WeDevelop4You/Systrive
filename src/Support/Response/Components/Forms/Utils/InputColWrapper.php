<?php

namespace Support\Response\Components\Forms\Utils;

use Support\Response\Components\Forms\Inputs\AbstractInputComponent;
use Support\Response\Components\Forms\Inputs\ConditionInputComponent;
use Support\Response\Components\Layouts\ColComponent;

class InputColWrapper
{
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
        if (!\is_null($vuexNamespace) && $this->input instanceof AbstractInputComponent) {
            $this->input->setVuexNamespace($vuexNamespace);
        }

        return $this->col->setComponent($this->input);
    }
}
