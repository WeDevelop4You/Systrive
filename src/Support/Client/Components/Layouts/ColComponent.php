<?php

namespace Support\Client\Components\Layouts;

use Support\Client\Components\Component;
use Support\Client\Traits\ComponentWithClasses;
use Support\Client\Traits\ComponentWithCol;
use Support\Enums\Component\Vuetify\VuetifyAlignSelfType;

class ColComponent extends Component
{
    use ComponentWithCol;
    use ComponentWithClasses;

    protected function __construct()
    {
        parent::__construct();

        $this->setDefaultCol();
    }

    /**
     * {@inheritDoc}
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
}
