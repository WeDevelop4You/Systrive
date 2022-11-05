<?php

namespace Support\Response\Components\Forms;

use Support\Enums\Component\Form\FormType;

class CustomFormComponent extends AbstractFormComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'CustomFormComponent';
    }

    /**
     * @param FormType $type
     *
     * @return CustomFormComponent
     */
    public function setType(FormType $type): CustomFormComponent
    {
        return $this->setData('type', $type->value);
    }

    /**
     * @param string $vuexNamespace
     *
     * @return CustomFormComponent
     */
    public function setVuexNamespace(string $vuexNamespace): static
    {
        return $this->setAttribute('vuex-namespace', $vuexNamespace);
    }
}
