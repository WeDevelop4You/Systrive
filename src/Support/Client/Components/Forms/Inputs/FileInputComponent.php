<?php

namespace Support\Client\Components\Forms\Inputs;

use Illuminate\Support\Collection;
use Symfony\Component\Mime\MimeTypes;

class FileInputComponent extends AbstractInputComponent
{
    /**
     * FileInputComponent constructor.
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
            )->unique()->toArray()
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
