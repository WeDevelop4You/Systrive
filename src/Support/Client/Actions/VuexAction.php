<?php

namespace Support\Client\Actions;

use Ramsey\Uuid\UuidInterface;
use Support\Client\Components\Popups\DialogComponent;
use Support\Utils\VuexNamespace;

class VuexAction extends Action
{
    /**
     * @param string|VuexNamespace $vuexNamespace
     * @param mixed|null           $params
     *
     * @return VuexAction
     */
    public function commit(string|VuexNamespace $vuexNamespace, mixed $params = null): VuexAction
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData([
            'type' => $value,
            'params' => $params,
        ])->setName('vuexCommitMethodAction');
    }

    /**
     * @param string|VuexNamespace $vuexNamespace
     * @param mixed                $params
     *
     * @return VuexAction
     */
    public function dispatch(string|VuexNamespace $vuexNamespace, mixed $params = null): VuexAction
    {
        $value = optional($vuexNamespace)->export() ?: $vuexNamespace;

        return $this->setData([
            'type' => $value,
            'params' => $params,
        ])->setName('vuexDispatchMethodAction');
    }

    /**
     * @param string|VuexNamespace $vuexNamespace
     *
     * @return VuexAction
     */
    public function refreshTable(string|VuexNamespace $vuexNamespace): VuexAction
    {
        return $this->dispatch("{$vuexNamespace}/getItems");
    }

    /**
     * @param string|VuexNamespace $vuexNamespace
     *
     * @return VuexAction
     */
    public function resetTable(string|VuexNamespace $vuexNamespace): VuexAction
    {
        return $this->dispatch("{$vuexNamespace}/reset");
    }

    /**
     * @param DialogComponent $component
     *
     * @return VuexAction
     */
    public function addDialog(DialogComponent $component): VuexAction
    {
        return $this->dispatch('popups/addDialog', $component->export());
    }

    /**
     * @param UuidInterface|null $identifier
     *
     * @return VuexAction
     */
    public function closeModal(UuidInterface|null $identifier = null): VuexAction
    {
        return $this->commit('popups/removeModal', $identifier);
    }

    /**
     * @return VuexAction
     */
    public function closeAllModals(): VuexAction
    {
        return $this->commit('popups/removeAllModals');
    }
}
