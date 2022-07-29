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
     * @param bool           $condition
     * @param AbstractAction $action
     *
     * @return ChainAction
     */
    public function addActionIf(bool $condition, AbstractAction $action): ChainAction
    {
        if ($condition) {
            return $this->addAction($action);
        }

        return $this;
    }

    /**
     * @param array $actions
     *
     * @return ChainAction
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
