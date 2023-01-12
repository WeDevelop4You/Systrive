<?php

namespace Support\Client\Components\Forms;

use Support\Client\Components\Component;
use Support\Helpers\VuexNamespaceHelper;

abstract class AbstractFormComponent extends Component
{
    /**
     * @param string|VuexNamespaceHelper $vuexNamespace
     *
     * @return static
     */
    abstract public function setVuexNamespace(string|VuexNamespaceHelper $vuexNamespace): static;
}
