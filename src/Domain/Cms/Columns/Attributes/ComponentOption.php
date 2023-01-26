<?php

namespace Domain\Cms\Columns\Attributes;

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