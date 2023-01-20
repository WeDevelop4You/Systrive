<?php

namespace Support\Client\Components\Navbar\Navigations;

/**
 * @method addNavigationIf(bool $condition, Items\NavigationItemComponent $navigation)
 */
class GroupNavigationComponent extends AbstractNavigationComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'GroupNavigationComponent';
    }
}
