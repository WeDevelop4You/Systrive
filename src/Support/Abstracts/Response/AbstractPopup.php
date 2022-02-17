<?php

    namespace Support\Abstracts\Response;

    use Illuminate\Support\Str;
    use Support\Enums\PopupTypes;

    abstract class AbstractPopup
    {
        /**
         * @param ...$arguments
         *
         * @return static
         */
        public static function create(...$arguments): static
        {
            return new static(...$arguments);
        }

        /**
         * @return PopupTypes
         */
        abstract public function getType(): PopupTypes;

        /**
         * @return string
         */
        abstract public function getComponent(): string;

        /**
         * @return array
         */
        abstract public function getData(): array;

        /**
         * @return array
         */
        public function export(): array
        {
            return [
                'show' => true,
                'data' => $this->getData(),
                'id' => Str::uuid()->toString(),
                'type' => $this->getType()->value,
                'component' => $this->getComponent(),
            ];
        }
    }
