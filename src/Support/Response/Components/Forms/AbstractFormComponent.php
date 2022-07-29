<?php

namespace Support\Response\Components\Forms;

use Support\Response\Components\AbstractComponent;

abstract class AbstractFormComponent extends AbstractComponent
{
    /**
     * @param string $vuexNamespace
     *
     * @return static
     */
    abstract public function setVuexNamespace(string $vuexNamespace): static;
}
