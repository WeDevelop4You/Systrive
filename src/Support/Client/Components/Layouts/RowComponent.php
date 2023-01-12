<?php

namespace Support\Client\Components\Layouts;

use Support\Client\Components\Attributes\ComponentWithClasses;
use Support\Client\Components\Attributes\ComponentWithIfStatement;
use Support\Client\Components\Component;
use Support\Enums\Component\Vuetify\VuetifyAlignType;
use Support\Enums\Component\Vuetify\VuetifyJustifyType;

/**
 * @method addColIf(bool $condition, ColComponent $col)
 */
class RowComponent extends Component
{
    use ComponentWithClasses;
    use ComponentWithIfStatement;

    /**
     * @inheritDoc
     */
    protected function getComponentName(): string
    {
        return 'RowComponent';
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
     * @param VuetifyAlignType $type
     *
     * @return RowComponent
     */
    public function setAlign(VuetifyAlignType $type): RowComponent
    {
        return $this->setAttribute('align', $type->value);
    }

    /**
     * @param VuetifyJustifyType $type
     *
     * @return RowComponent
     */
    public function setJustify(VuetifyJustifyType $type): RowComponent
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
