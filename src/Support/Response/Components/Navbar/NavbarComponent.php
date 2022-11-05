<?php

namespace Support\Response\Components\Navbar;

use Support\Response\Components\AbstractComponent;
use Support\Response\Components\Navbar\Navigations\AbstractNavigationComponent;

class NavbarComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'NavbarComponent';
    }

    /**
     * @param string $title
     *
     * @return NavbarComponent
     */
    public function addSubheader(string $title): NavbarComponent
    {
        return $this->setData('list', ['subheader' => $title], true);
    }

    /**
     * @return NavbarComponent
     */
    public function addDivider(): NavbarComponent
    {
        return $this->setData('list', ['divider' => true], true);
    }

    /**
     * @param AbstractNavigationComponent[]|array $items
     *
     * @return NavbarComponent
     */
    public function addItems(array $items): NavbarComponent
    {
        foreach ($items as $item) {
            if ($item instanceof AbstractNavigationComponent) {
                $this->addItem($item);
            }
        }

        return $this;
    }

    /**
     * @param AbstractNavigationComponent $item
     *
     * @return NavbarComponent
     */
    public function addItem(AbstractNavigationComponent $item): NavbarComponent
    {
        return $this->setData('list', $item->export(), true);
    }

    /**
     * @return NavbarComponent
     */
    public function setShaped(): NavbarComponent
    {
        return $this->setAttribute('shaped', true);
    }

    /**
     * @return NavbarComponent
     */
    public function setNav(): NavbarComponent
    {
        return $this->setAttribute('nav', true);
    }
}
