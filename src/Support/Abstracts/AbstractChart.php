<?php

    namespace Support\Abstracts;

    abstract class AbstractChart
    {
        /**
         * @var array
         */
        private array $labels = [];

        /**
         * @var array
         */
        private array $data = [];

        /**
         * @return array
         */
        public static function create(): array
        {
            $instance = new static();
            $instance->handle();

            return $instance->toArray();
        }

        /**
         * @param array $labels
         */
        protected function setLabels(array $labels): void
        {
            $this->labels = $labels;
        }

        /**
         * @param array $data
         *
         * @return void
         */
        protected function setData(array $data): void
        {
            $this->data = $data;
        }

        /**
         * @param string $key
         * @param array  $data
         */
        protected function addData(string $key, array $data): void
        {
            $this->data[$key] = $data;
        }

        /**
         * @return array
         */
        private function toArray(): array
        {
            return [
                'labels' => $this->labels,
                'data' => $this->data,
            ];
        }

        abstract protected function handle(): void;
    }
