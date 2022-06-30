<?php

namespace Support\Response\Components\Forms;

use Support\Response\Components\Forms\Helpers\ColWithInputHelper;
use Support\Response\Components\Layouts\RowComponent;

class FormComponent extends AbstractFormComponent
{
    /**
     * @var string|null
     */
    private ?string $vuexNamespace = null;

    /**
     * @var array|ColWithInputHelper[]
     */
    private array $inputs = [];

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'FormLayout';
    }

    /**
     * @inheritDoc
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        $this->vuexNamespace = $vuexNamespace;

        return $this;
    }

    /**
     * @param array $inputs
     *
     * @return FormComponent
     */
    public function setInputs(array $inputs): FormComponent
    {
        foreach ($inputs as $input) {
            if ($input instanceof ColWithInputHelper) {
                $this->addInput($input);
            }
        }

        return $this;
    }

    /**
     * @param ColWithInputHelper $input
     *
     * @return FormComponent
     */
    public function addInput(ColWithInputHelper $input): FormComponent
    {
        $this->inputs[] = $input;

        return $this;
    }

    public function export(): array
    {
        $row = RowComponent::create()->setDense();

        foreach ($this->inputs as $input) {
            $row->addCol($input->export($this->vuexNamespace));
        }

        $this->setData('form', $row->export());

        return parent::export();
    }
}
