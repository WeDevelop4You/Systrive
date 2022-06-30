<?php

    namespace Support\Response\Actions;

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
            ])->setMethod('actionVuexCommitMethod');
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
            ])->setMethod('actionVuexDispatchMethod');
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
    }
