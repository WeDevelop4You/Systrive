<?php

namespace Support\Client\Components\Forms\Inputs;

class FileInputComponent extends AbstractFileInputComponent
{
    /**
     * {@inheritDoc}
     */
    protected function getComponentName(): string
    {
        return 'FileInputComponent';
    }

    /**
     * {@inheritDoc}
     */
    protected function getPlaceholderText(bool $multiple): string
    {
        return $multiple ? trans('text.select.files') : trans('text.select.file');
    }
}
