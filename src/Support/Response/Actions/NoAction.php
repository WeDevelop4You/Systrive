<?php

namespace Support\Response\Actions;

class NoAction extends AbstractAction
{
    /**
     * NoAction constructor.
     */
    protected function __construct()
    {
        $this->setMethod('noAction');
    }
}
