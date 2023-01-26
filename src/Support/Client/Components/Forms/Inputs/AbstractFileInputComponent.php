<?php

namespace Support\Client\Components\Forms\Inputs;

use Illuminate\Support\Collection;
use Symfony\Component\Mime\MimeTypes;

abstract class AbstractFileInputComponent extends AbstractInputComponent
{
    /**
     * AbstractFileInputComponent constructor
     */
    protected function __construct()
    {
        parent::__construct();

        $this->setPlaceholderSelect()->setMax();
    }

    /**
     * @param array $extensions
     *
     * @return $this
     */
    public function setAccept(array $extensions): static
    {
        return $this->setAttribute(
            'accept',
            Collection::make($extensions)->map(
                fn (string $extension) => (new MimeTypes())->getMimeTypes($extension)
            )->unique()->flatten()->toArray()
        );
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
     * @param bool $condition
     *
     * @return $this
     */
    public function setReadonly(bool $condition = true): static
    {
        return $this->setDisabled($condition);
    }

    /**
     * @param bool $multiple
     *
     * @return $this
     */
    private function setPlaceholderSelect(bool $multiple = false): static
    {
        return $this->setPlaceholder($this->getPlaceholderText($multiple))
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

    /**
     * @param bool $multiple
     *
     * @return string
     */
    abstract protected function getPlaceholderText(bool $multiple): string;
}
