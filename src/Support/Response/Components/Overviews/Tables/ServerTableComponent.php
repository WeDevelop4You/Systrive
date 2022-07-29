<?php

namespace Support\Response\Components\Overviews\Tables;

class ServerTableComponent extends AbstractTableComponent
{
    /**
     * @inheritDoc
     */
    protected function getType(): string
    {
        return 'ServerDataTable';
    }
}
