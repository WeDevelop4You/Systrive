<?php

namespace Support\Response\Components\Forms;

use Support\Enums\Component\FormTypes;

class CustomFormComponent extends AbstractFormComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'CustomFormLayout';
    }

    /**
     * @param FormTypes $type
     *
     * @return CustomFormComponent
     */
    public function setType(FormTypes $type): CustomFormComponent
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
