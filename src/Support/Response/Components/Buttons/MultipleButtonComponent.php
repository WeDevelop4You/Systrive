<?php

namespace Support\Response\Components\Buttons;

use Support\Response\Components\AbstractComponent;
use Support\Traits\ComponentWithClasses;

class MultipleButtonComponent extends AbstractComponent
{
    use ComponentWithClasses;

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'MultipleBtn';
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

    /**
     * @param bool                    $condition
     * @param AbstractButtonComponent $button
     *
     * @return MultipleButtonComponent
     */
    public function addButtonIf(bool $condition, AbstractButtonComponent $button): MultipleButtonComponent
    {
        return $condition ? $this->addButton($button) : $this;
    }
}
