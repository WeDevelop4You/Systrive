<?php

namespace Support\Client\Components\Buttons;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Attributes\ComponentWithIfStatement;
use Support\Client\Components\Component;

/**
 * @method addButtonIf(bool $condition, AbstractButtonComponent $button)
 */
class MultipleButtonComponent extends Component
{
    use ComponentWithClasses;
    use ComponentWithIfStatement;

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'MultipleBtnComponent';
    }

    /**
     * @param array $buttons
     *
     * @return $this
     */
    public function setButtons(array $buttons): MultipleButtonComponent
    {
        foreach ($buttons as $button) {
            if ($button instanceof AbstractButtonComponent) {
                $this->addButton($button);
            }
        }

        return $this;
    }

    public function addButton(AbstractButtonComponent $button): MultipleButtonComponent
    {
        return $this->setData('buttons', $button->export(), true);
    }
}
