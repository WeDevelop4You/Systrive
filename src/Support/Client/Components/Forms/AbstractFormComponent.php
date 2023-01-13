<?php

namespace Support\Client\Components\Forms;

use Support\Client\Components\Component;
use Support\Utils\VuexNamespace;

abstract class AbstractFormComponent extends Component
{
    /**
     * @param string|VuexNamespace $vuexNamespace
     *
     * @return static
     */
    abstract public function setVuexNamespace(string|VuexNamespace $vuexNamespace): static;
}
