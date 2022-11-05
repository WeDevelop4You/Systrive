<?php

    namespace Support\Response\Components\Popups;

    use Support\Enums\Component\PopupType;
    use Support\Response\Components\AbstractComponent;

    abstract class AbstractPopupComponent extends AbstractComponent
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
