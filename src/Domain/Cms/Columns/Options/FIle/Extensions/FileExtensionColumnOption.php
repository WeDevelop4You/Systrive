<?php

namespace Domain\Cms\Columns\Options\FIle\Extensions;

class FileExtensionColumnOption extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    protected function extensions(): array
    {
        return [
            'pdf',
            'doc',
            'docx',
            'xls',
            'xlsx',
            'ppt',
            'pptx',
            'txt',
        ];
    }
}
