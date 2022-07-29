<?php

namespace Support\Response\Components\Forms\Helpers;

class SelectInputValueHelper
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
     * @return SelectInputValueHelper
     */
    public static function create(): SelectInputValueHelper
    {
        return new static();
    }

    /**
     * @param mixed $text
     *
     * @return SelectInputValueHelper
     */
    public function setText(mixed $text): SelectInputValueHelper
    {
        return $this->setData('text', $text);
    }

    /**
     * @param mixed $value
     *
     * @return SelectInputValueHelper
     */
    public function setValue(mixed $value): SelectInputValueHelper
    {
        return $this->setData('value', $value);
    }

    /**
     * @param bool $disabled
     *
     * @return SelectInputValueHelper
     */
    public function setDisabled(bool $disabled): SelectInputValueHelper
    {
        return $this->setData('disabled', $disabled);
    }

    /**
     * @param bool $divider
     *
     * @return SelectInputValueHelper
     */
    public function setDivider(bool $divider): SelectInputValueHelper
    {
        return $this->setData('divider', $divider);
    }

    /**
     * @param string $header
     *
     * @return SelectInputValueHelper
     */
    public function setHeader(string $header): SelectInputValueHelper
    {
        return $this->setData('header', $header);
    }

    /**
     * @param string $key
     * @param mixed  $data
     *
     * @return SelectInputValueHelper
     */
    private function setData(string $key, mixed $data): SelectInputValueHelper
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
