<?php

namespace Domain\Cms\Columns\Definitions;

use Support\Client\Components\Layouts\ColComponent;

interface ComponentOption
{
    /**
     * @param bool $isEditing
     *
     * @return ColComponent
     */
    public function getComponent(bool $isEditing): ColComponent;
}
