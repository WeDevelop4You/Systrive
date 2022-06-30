<?php

    namespace Support\Response\Actions;

    use Ramsey\Uuid\UuidInterface;

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

        private AbstractAction|null $onSuccess = null;

        /**
         * @return static
         */
        public static function create(): static
        {
            return new static();
        }

        /**
         * @param string $method
         *
         * @return $this
         */
        final protected function setMethod(string $method): static
        {
            $this->method = $method;

            return $this;
        }

        final protected function setData(array $data, bool $isArray = false): static
        {
            $isArray ? $this->data[] = $data : $this->data = $data;

            return $this;
        }

        /**
         * @param AbstractAction $action
         *
         * @return $this
         */
        final public function setOnSuccess(AbstractAction $action): static
        {
            $this->onSuccess = $action;

            return $this;
        }

        /**
         * @param UuidInterface|null $identifier
         *
         * @return $this
         */
        final public function setOnSuccessAsClosePopupModal(UuidInterface|null $identifier = null): static
        {
            $this->onSuccess = PopupModalAction::create()->close($identifier);

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
                'onSuccess' => $this->onSuccess?->export(),
            ];
        }
    }
