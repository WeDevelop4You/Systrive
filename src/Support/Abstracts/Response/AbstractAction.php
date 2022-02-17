<?php

    namespace Support\Abstracts\Response;

    abstract class AbstractAction
    {
        /**
         * @var string
         */
        private string $method;

        /**
         * @var array
         */
        private array $data = [];

        /**
         * @param mixed ...$arguments
         *
         * @return static
         */
        public static function create(...$arguments): static
        {
            return new static(...$arguments);
        }

        /**
         * @param string $method
         *
         * @return $this
         */
        final public function setMethod(string $method): static
        {
            $this->method = $method;

            return $this;
        }

        final public function setData(array $data): static
        {
            $this->data = $data;

            return $this;
        }

        /**
         * @return array
         */
        final public function export(): array
        {
            return [
                'method' => $this->method,
                'data' => $this->data,
            ];
        }
    }
