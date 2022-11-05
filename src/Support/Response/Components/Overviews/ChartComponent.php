<?php

namespace Support\Response\Components\Overviews;

use Support\Enums\Component\ChartType;
use Support\Response\Components\AbstractComponent;

class ChartComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'ChartComponent';
    }

    /**
     * @param ChartType $type
     *
     * @return ChartComponent
     */
    public function setType(ChartType $type): ChartComponent
    {
        return $this->setData('type', $type->value);
    }

    /**
     * @param string $url
     *
     * @return ChartComponent
     */
    public function setUrl(string $url): ChartComponent
    {
        return $this->setData('url', $url);
    }
}
