<?php

namespace Support\Response\Components\Navbar\Navigations;

use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Navbar\Navigations\Items\AbstractNavigationItemComponent;

abstract class AbstractNavigationComponent extends AbstractComponent
{
    /**
     * @param AbstractNavigationItemComponent[]|array $navigations
     *
     * @return static
     */
    public function setNavigation(array $navigations): static
    {
        foreach ($navigations as $navigation) {
            if ($navigation instanceof AbstractNavigationItemComponent) {
                $this->addNavigation($navigation);
            }
        }

        return $this;
    }

    /**
     * @param AbstractNavigationItemComponent $navigation
     *
     * @return static
     */
    public function addNavigation(AbstractNavigationItemComponent $navigation): static
    {
        return $this->setData('navigations', $navigation->export(), true);
    }

    /**
     * @param bool                            $condition
     * @param AbstractNavigationItemComponent $navigation
     *
     * @return static
     */
    public function addNavigationIf(bool $condition, AbstractNavigationItemComponent $navigation): static
    {
        return $condition ? $this->addNavigation($navigation) : $this;
    }
}
