<?php

    namespace Support\Response\Components\Popups;

    use Support\Enums\PopupTypes;
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
         * @return PopupTypes
         */
        abstract protected function getType(): PopupTypes;
    }
