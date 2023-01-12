<?php

namespace Support\Client\Components\Layouts;

use Support\Client\Components\Component;
use Support\Enums\Component\Vuetify\VuetifyAlignSelfType;

class ColComponent extends Component
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
        return 'ColComponent';
    }

    /**
     * @param Component $component
     *
     * @return ColComponent
     */
    public function setComponent(Component $component): ColComponent
    {
        return $this->setData('component', $component->export());
    }

    /**
     * @param VuetifyAlignSelfType $alignSelf
     *
     * @return ColComponent
     */
    public function setAlignSelf(VuetifyAlignSelfType $alignSelf): ColComponent
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
