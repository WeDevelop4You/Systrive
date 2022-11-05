<?php

namespace Support\Response\Components\Forms;

use Support\Response\Components\Forms\Utils\InputColWrapper;
use Support\Response\Components\Layouts\RowComponent;
use Support\Traits\ComponentWithClasses;

class FormComponent extends AbstractFormComponent
{
    use ComponentWithClasses;

    /**
     * @var string|null
     */
    private ?string $vuexNamespace = null;

    /**
     * @var array|InputColWrapper[]
     */
    private array $inputs = [];

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
    public function setVuexNamespace(string $vuexNamespace): static
    {
        $this->vuexNamespace = $vuexNamespace;

        return $this->setAttribute('vuex-namespace', $vuexNamespace);
    }

    /**
     * @param array $inputs
     *
     * @return $this
     */
    public function setInputs(array $inputs): FormComponent
    {
        foreach ($inputs as $input) {
            if ($input instanceof InputColWrapper) {
                $this->addInput($input);
            }
        }

        return $this;
    }

    /**
     * @param InputColWrapper $input
     *
     * @return $this
     */
    public function addInput(InputColWrapper $input): FormComponent
    {
        $this->inputs[] = $input;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return $this
     */
    public function addClass(string $class): FormComponent
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
            ->setClasses($this->classes);

        foreach ($this->inputs as $input) {
            $row->addCol($input->export($this->vuexNamespace));
        }

        $this->setData('form', $row->export());

        return parent::export();
    }
}
