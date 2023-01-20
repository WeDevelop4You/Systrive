<?php

namespace Support\Client\Components\Popups;

use Support\Client\Components\Component;
use Support\Enums\Component\PopupType;

abstract class AbstractPopupComponent extends Component
{
    protected function __construct()
    {
        parent::__construct();

        $this->setData('show', true);
        $this->setData('type', $this->getType()->value);
    }

    /**
     * @return PopupType
     */
    abstract protected function getType(): PopupType;
}
