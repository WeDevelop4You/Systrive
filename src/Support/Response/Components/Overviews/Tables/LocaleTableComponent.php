<?php

namespace Support\Response\Components\Overviews\Tables;

class LocaleTableComponent extends AbstractTableComponent
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'LocaleDataTableComponent';
    }

    /**
     * @return LocaleTableComponent
     */
    public function setDisablePagination(): LocaleTableComponent
    {
        return $this->setAttribute('disablePagination', true);
    }
}
