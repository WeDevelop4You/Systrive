<?php

namespace Support\Client\Actions;

class ChainAction extends Action
{
    /**
     * ChainAction constructor.
     */
    protected function __construct()
    {
        $this->setName('chainAction');
    }

    /**
     * @param Action $action
     *
     * @return ChainAction
     */
    public function addAction(Action $action): ChainAction
    {
        return $this->setData($action->export(), true);
    }

    /**
     * @param bool   $condition
     * @param Action $action
     *
     * @return ChainAction
     */
    public function addActionIf(bool $condition, Action $action): ChainAction
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
            if ($action instanceof Action) {
                $this->addAction($action);
            }
        }

        return $this;
    }
}
