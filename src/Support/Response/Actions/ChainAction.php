<?php

namespace Support\Response\Actions;

class ChainAction extends AbstractAction
{
    /**
     * ChainAction constructor.
     */
    protected function __construct()
    {
        $this->setMethod('actionChain');
    }

    /**
     * @param AbstractAction $action
     *
     * @return ChainAction
     */
    public function addAction(AbstractAction $action): ChainAction
    {
        return $this->setData($action->export(), true);
    }

    /**
     * @param array $actions
     *
     * @return $this
     */
    public function setActions(array $actions): ChainAction
    {
        foreach ($actions as $action) {
            if ($action instanceof AbstractAction) {
                $this->addAction($action);
            }
        }

        return $this;
    }
}
