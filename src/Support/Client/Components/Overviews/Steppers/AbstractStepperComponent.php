<?php

namespace Support\Client\Components\Overviews\Steppers;

use Support\Client\Components\Component;
use Support\Utils\VuexNamespace;

abstract class AbstractStepperComponent extends Component
{
    private int $steps = 1;

    protected function __construct()
    {
        parent::__construct();

        $this->setRounded();
        $this->setOutlined();
        $this->setHasHeader(false);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setRounded(bool $value = true): static
    {
        return $this->setAttribute('rounded', $value ? 'lg' : false);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    public function setOutlined(bool $value = true): static
    {
        return $this->setAttribute('outlined', $value);
    }

    /**
     * @param int $value
     *
     * @return $this
     */
    public function setWidth(int $value): static
    {
        return $this->setAttribute('width', $value);
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function setHeader(Component $component): static
    {
        return $this->setData('header', $component->export())->setHasHeader();
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function setItems(array $items): static
    {
        foreach ($items as $item) {
            if ($item instanceof StepperItemComponent) {
                $this->addItem($item);
            }
        }

        return $this;
    }

    /**
     * @param StepperItemComponent $item
     *
     * @return $this
     */
    public function addItem(StepperItemComponent $item): static
    {
        return $this->setData('items', $item->setStep($this->steps++)->export(), true);
    }

    /**
     * @param bool $value
     *
     * @return $this
     */
    private function setHasHeader(bool $value = true): static
    {
        return $this->setData('hasHeader', $value);
    }

    /**
     * @param string|VuexNamespace $vuexNamespace
     *
     * @return $this
     */
    public function setVuexNamespace(string|VuexNamespace $vuexNamespace): static
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData('vuexNamespace', $value);
    }
}
