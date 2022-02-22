<?php

namespace Support\Abstracts;

abstract class AbstractListItem
{
    /**
     * AbstractListItem constructor.
     *
     * @param string $identifier
     * @param string $label
     * @param mixed  $value
     */
    private function __construct(
        private string $identifier,
        private string $label,
        private mixed $value = '',
    ) {
        //
    }

    /**
     * @param string $identifier
     * @param string $label
     * @param mixed  $value
     *
     * @return static
     */
    public static function create(string $identifier, string $label, mixed $value = ''): static
    {
        return new static($identifier, $label, $value);
    }

    /**
     * @return string
     */
    abstract protected function getType(): string;

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return array
     */
    final public function export(): array
    {
        return [
           'label' => $this->label,
           'value' => $this->value,
           'type' => $this->getType(),
           'identifier' => $this->identifier,
       ];
    }
}
