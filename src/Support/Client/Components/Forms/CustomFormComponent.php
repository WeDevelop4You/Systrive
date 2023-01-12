<?php

namespace Support\Client\Components\Forms;

use Support\Enums\Component\Form\FormType;
use Support\Helpers\VuexNamespaceHelper;

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
     * @return static
     */
    public function setType(FormType $type): CustomFormComponent
    {
        return $this->setData('type', $type->value);
    }

    /**
     * @param string|VuexNamespaceHelper $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string|VuexNamespaceHelper $vuexNamespace): static
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData('vuexNamespace', $value);
    }
}
