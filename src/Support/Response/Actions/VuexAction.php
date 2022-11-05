<?php

    namespace Support\Response\Actions;

    use Ramsey\Uuid\UuidInterface;

    class VuexAction extends AbstractAction
    {
        /**
         * @param string     $type
         * @param mixed|null $params
         *
         * @return VuexAction
         */
        public function commit(string $type, mixed $params = null): VuexAction
        {
            return $this->setData([
                'type' => $type,
                'params' => $params,
            ])->setMethod('vuexCommitMethodAction');
        }

        /**
         * @param string $type
         * @param mixed  $params
         *
         * @return VuexAction
         */
        public function dispatch(string $type, mixed $params = null): VuexAction
        {
            return $this->setData([
                'type' => $type,
                'params' => $params,
            ])->setMethod('vuexDispatchMethodAction');
        }

        /**
         * @param string $vuexNamespace
         *
         * @return VuexAction
         */
        public function refreshTable(string $vuexNamespace): VuexAction
        {
            return $this->dispatch("{$vuexNamespace}/getItems");
        }

        /**
         * @param string $vuexNamespace
         *
         * @return VuexAction
         */
        public function resetTable(string $vuexNamespace): VuexAction
        {
            return $this->dispatch("{$vuexNamespace}/reset");
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
