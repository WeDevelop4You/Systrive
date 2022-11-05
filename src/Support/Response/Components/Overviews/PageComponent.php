<?php

namespace Support\Response\Components\Overviews;

use Support\Response\Components\AbstractComponent;

class PageComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'PageComponent';
    }

    /**
     * @param string $vuexNamespace
     *
     * @return PageComponent
     */
    public function setVuexNamespace(string $vuexNamespace): PageComponent
    {
        return $this->setData('vuexNamespace', $vuexNamespace);
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
