<?php

namespace Support\Client\Components\Navbar\Navigations;

use Support\Client\Components\Attributes\ComponentWithIfStatement;
use Support\Client\Components\Component;
use Support\Client\Components\Navbar\Navigations\Items\AbstractNavigationItemComponent;

abstract class AbstractNavigationComponent extends Component
{
    use ComponentWithIfStatement;

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
}
