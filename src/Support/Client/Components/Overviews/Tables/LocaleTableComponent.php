<?php

namespace Support\Client\Components\Overviews\Tables;

class LocaleTableComponent extends AbstractTableComponent
{
    /**
     * @return string
     */
    protected function getComponentName(): string
    {
        return 'LocaleDataTableComponent';
    }

    /**
     * @return LocaleTableComponent
     */
    public function setDisablePagination(): LocaleTableComponent
    {
        return $this->setData('disablePagination', true);
    }
}
