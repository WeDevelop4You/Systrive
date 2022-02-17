<?php

    namespace Support\Helpers\Response\Action\Methods;

    use Support\Abstracts\Response\AbstractAction;

    class VuexMethods extends AbstractAction
    {
        /**
         * @param string     $type
         * @param mixed|null $params
         *
         * @return VuexMethods
         */
        public function commit(string $type, mixed $params = null): VuexMethods
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
         * @return VuexMethods
         */
        public function dispatch(string $type, mixed $params = null): VuexMethods
        {
            return $this->setData([
                'type' => $type,
                'params' => $params,
            ])->setMethod('actionVuexDispatchMethod');
        }
    }
