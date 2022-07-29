<?php

namespace Support\Response\Components\Layouts;

use Support\Enums\Component\Vuetify\VuetifyAlignTypes;
use Support\Enums\Component\Vuetify\VuetifyJustifyTypes;
use Support\Response\Components\AbstractComponent;
use Support\Traits\ComponentWithClasses;

class RowComponent extends AbstractComponent
{
    use ComponentWithClasses;

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'Row';
    }

    /**
     * @return RowComponent
     */
    public function setDense(): RowComponent
    {
        return $this->setAttribute('dense', true);
    }

    /**
     * @return RowComponent
     */
    public function setNoGutters(): RowComponent
    {
        return $this->setAttribute('no-gutters', true);
    }

    /**
     * @param VuetifyAlignTypes $type
     *
     * @return RowComponent
     */
    public function setAlign(VuetifyAlignTypes $type): RowComponent
    {
        return $this->setAttribute('align', $type->value);
    }

    /**
     * @param VuetifyJustifyTypes $type
     *
     * @return RowComponent
     */
    public function setJustify(VuetifyJustifyTypes $type): RowComponent
    {
        return $this->setAttribute('justify', $type->value);
    }

    /**
     * @param array $cols
     *
     * @return RowComponent
     */
    public function setCols(array $cols): RowComponent
    {
        foreach ($cols as $col) {
            if ($col instanceof ColComponent) {
                $this->addCol($col);
            }
        }

        return $this;
    }

    /**
     * @param ColComponent $col
     *
     * @return RowComponent
     */
    public function addCol(ColComponent $col): RowComponent
    {
        return $this->setData('cols', $col->export(), true);
    }
}
