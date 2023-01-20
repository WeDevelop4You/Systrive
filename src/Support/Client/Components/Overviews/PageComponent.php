<?php

namespace Support\Client\Components\Overviews;

use Support\Client\Components\Component;
use Support\Utils\VuexNamespace;

class PageComponent extends Component
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'PageComponent';
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

    /**
     * @param string $route
     *
     * @return PageComponent
     */
    public function setRoute(string $route): PageComponent
    {
        return $this->setData('route', $route);
    }
}
