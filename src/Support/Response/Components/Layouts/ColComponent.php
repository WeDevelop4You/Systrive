<?php

namespace Support\Response\Components\Layouts;

use Support\Enums\Component\Vuetify\VuetifyAlignSelfTypes;
use Support\Response\Components\AbstractComponent;

class ColComponent extends AbstractComponent
{
    protected function __construct()
    {
        parent::__construct();

        $this->setDefaultCol();
    }

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Col';
    }

    /**
     * @param AbstractComponent $component
     *
     * @return ColComponent
     */
    public function setComponent(AbstractComponent $component): ColComponent
    {
        return $this->setData('component', $component->export());
    }

    /**
     * @param VuetifyAlignSelfTypes $alignSelf
     *
     * @return ColComponent
     */
    public function setAlignSelf(VuetifyAlignSelfTypes $alignSelf): ColComponent
    {
        return $this->setAttribute('align-self', $alignSelf->value);
    }

    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setDefaultCol(string|int $length = 12): ColComponent
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('cols', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return $this
     */
    public function setMdCol(string|int $length = 12): ColComponent
    {
        if ($this->isBetween($length)) {
            $this->setAttribute('md', $length);
        }

        return $this;
    }

    /**
     * @param int|string $length
     *
     * @return bool
     */
    private function isBetween(string|int $length): bool
    {
        return $length === 'auto' || ($length <= 12 && $length > 0);
    }
}
