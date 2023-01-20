<?php

namespace Support\Client\Components\Overviews;

use Support\Client\Components\Component;
use Support\Enums\Component\ChartType;

class ChartComponent extends Component
{
    /**
     * {@inheritDoc}
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
