<?php

namespace Support\Response\Components\Overviews;

use Support\Enums\Component\ChartTypes;
use Support\Response\Components\AbstractComponent;

class ChartComponent extends AbstractComponent
{
    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Chart';
    }

    /**
     * @param ChartTypes $type
     *
     * @return ChartComponent
     */
    public function setType(ChartTypes $type): ChartComponent
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
