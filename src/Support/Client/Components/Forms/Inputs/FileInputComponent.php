<?php

namespace Support\Client\Components\Forms\Inputs;

class FileInputComponent extends AbstractInputComponent
{
    /**
     * FileInputComponent constructor
     */
    protected function __construct()
    {
        parent::__construct();

        $this->setPlaceholderSelect()->setMax();
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'FileInputComponent';
    }

    /**
     * @param bool $condition
     * @param int  $max
     *
     * @return $this
     */
    public function setMultiple(bool $condition = true, int $max = 5): static
    {
        return $this->setAttribute('multiple', $condition)
            ->setPlaceholderSelect($condition)
            ->setMax($condition ? $max : 1);
    }

    /**
     * @param string $route
     *
     * @return $this
     */
    public function setUploaderRoute(string $route): static
    {
        return $this->setData('uploaderRoute', $route);
    }

    /**
     * @param bool $multiple
     *
     * @return $this
     */
    private function setPlaceholderSelect(bool $multiple = false): static
    {
        $text = $multiple
            ? trans('text.select.files')
            : trans('text.select.file');

        return $this->setPlaceholder($text)
            ->setPersistentPlaceholder();
    }

    /**
     * @param int $total
     *
     * @return $this
     */
    private function setMax(int $total = 1): static
    {
        return $this->setData('max', $total);
    }
}
