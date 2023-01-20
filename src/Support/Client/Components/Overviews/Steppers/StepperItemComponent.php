<?php

namespace Support\Client\Components\Overviews\Steppers;

use Support\Client\Components\Component;
use Support\Client\Components\Layouts\ColComponent;
use Support\Client\Components\Layouts\RowComponent;

class StepperItemComponent extends Component
{
    private RowComponent $row;

    protected function __construct()
    {
        parent::__construct();

        $this->row = RowComponent::create()
            ->setClass(['gap-3', 'pt-2'])
            ->setNoGutters();
    }

    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'StepperItemComponent';
    }

    /**
     * @param int $step
     *
     * @return $this
     */
    public function setStep(int $step): static
    {
        return $this->setData('step', $step);
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): static
    {
        return $this->setContent('title', $title);
    }

    /**
     * @param array $components
     *
     * @return $this
     */
    public function setComponents(array $components): static
    {
        foreach ($components as $component) {
            if ($component instanceof Component) {
                $this->addComponent($component);
            }
        }

        return $this;
    }

    /**
     * @param Component $component
     *
     * @return $this
     */
    public function addComponent(Component $component): static
    {
        $this->row->addCol(
            ColComponent::create()->setComponent($component)
        );

        return $this;
    }

    public function export(): array
    {
        $this->setData('content', $this->row->export());

        return parent::export();
    }
}
