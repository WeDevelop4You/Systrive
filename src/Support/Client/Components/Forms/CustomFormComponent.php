<?php

namespace Support\Client\Components\Forms;

use Support\Enums\Component\Form\FormType;
use Support\Utils\VuexNamespace;

class CustomFormComponent extends AbstractFormComponent
{
    /**
     * {@inheritDoc}
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
     * @param string|VuexNamespace $vuexNamespace
     *
     * @return static
     */
    public function setVuexNamespace(string|VuexNamespace $vuexNamespace): static
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData('vuexNamespace', $value);
    }
}
