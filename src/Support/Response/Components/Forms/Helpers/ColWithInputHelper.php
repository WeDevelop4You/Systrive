<?php

namespace Support\Response\Components\Forms\Helpers;

use Support\Response\Components\Forms\InputTypes\AbstractInputComponent;
use Support\Response\Components\Layouts\ColComponent;

class ColWithInputHelper
{
    /**
     * @var ColComponent
     */
    private ColComponent $col;

    /**
     * @var AbstractInputComponent
     */
    private AbstractInputComponent $input;

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
     * @return ColWithInputHelper
     */
    public function setCol(ColComponent $col): ColWithInputHelper
    {
        $this->col = $col;

        return $this;
    }

    /**
     * @param AbstractInputComponent $input
     *
     * @return ColWithInputHelper
     */
    public function setInput(AbstractInputComponent $input): ColWithInputHelper
    {
        $this->input = $input;

        return $this;
    }

    public function export(?string $vuexNamespace = null): ColComponent
    {
        if (!is_null($vuexNamespace)) {
            $this->input->setVuexNamespace($vuexNamespace);
        }

        return $this->col->setComponent($this->input);
    }
}
