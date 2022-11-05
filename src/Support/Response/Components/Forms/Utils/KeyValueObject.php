<?php

namespace Support\Response\Components\Forms\Utils;

class KeyValueObject
{
    /**
     * @var array
     */
    private array $data = [];

    /**
     * SelectInputValueHelper constructor.
     */
    private function __construct()
    {
        //
    }

    /**
     * @return KeyValueObject
     */
    public static function create(): KeyValueObject
    {
        return new static();
    }

    /**
     * @param mixed $text
     *
     * @return KeyValueObject
     */
    public function setText(mixed $text): KeyValueObject
    {
        return $this->setData('text', $text);
    }

    /**
     * @param mixed $value
     *
     * @return KeyValueObject
     */
    public function setValue(mixed $value): KeyValueObject
    {
        return $this->setData('value', $value);
    }

    /**
     * @param bool $disabled
     *
     * @return KeyValueObject
     */
    public function setDisabled(bool $disabled): KeyValueObject
    {
        return $this->setData('disabled', $disabled);
    }

    /**
     * @param bool $divider
     *
     * @return KeyValueObject
     */
    public function setDivider(bool $divider): KeyValueObject
    {
        return $this->setData('divider', $divider);
    }

    /**
     * @param string $header
     *
     * @return KeyValueObject
     */
    public function setHeader(string $header): KeyValueObject
    {
        return $this->setData('header', $header);
    }

    /**
     * @param mixed $data
     *
     * @return KeyValueObject
     */
    public function setAdditionalData(mixed $data): KeyValueObject
    {
        return $this->setData('additional', $data);
    }

    /**
     * @param string $key
     * @param mixed  $data
     *
     * @return KeyValueObject
     */
    private function setData(string $key, mixed $data): KeyValueObject
    {
        $this->data[$key] = $data;

        return $this;
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return $this->data;
    }
}
