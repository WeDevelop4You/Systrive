<?php

namespace Support\Client\Components\Forms;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Forms\Utils\InputColWrapper;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;
use Support\Utils\VuexNamespace;

class FormComponent extends AbstractFormComponent
{
    use ComponentWithClasses;

    /**
     * @var string|null
     */
    private ?string $vuexNamespace = null;

    /**
     * @var array
     */
    private array $items = [];

    /**
     * @var array
     */
    private array $classes = [];

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'FormComponent';
    }

    /**
     * @inheritDoc
     */
    public function setVuexNamespace(string|VuexNamespace $vuexNamespace): static
    {
        $this->vuexNamespace = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this;
    }

    /**
     * @param array $items
     *
     * @return $this
     */
    public function setItems(array $items): FormComponent
    {
        foreach ($items as $item) {
            if ($item instanceof InputColWrapper || $item instanceof ColComponent) {
                $this->addItem($item);
            }
        }

        return $this;
    }

    /**
     * @param ColComponent|InputColWrapper $item
     *
     * @return $this
     */
    public function addItem(InputColWrapper|ColComponent $item): FormComponent
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function setClass(string $class): FormComponent
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        $row = RowComponent::create()
            ->setDense()
            ->setClass($this->classes);

        foreach ($this->items as $item) {
            if ($item instanceof InputColWrapper) {
                $row->addColIf($item->getCondition(), $item->export($this->vuexNamespace));
            }

            if ($item instanceof ColComponent) {
                $row->addCol($item);
            }
        }

        $this->setData('form', $row->export());
        $this->setData('vuexNamespace', $this->vuexNamespace);

        return parent::export();
    }
}
