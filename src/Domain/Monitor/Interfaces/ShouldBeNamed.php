<?php

namespace Domain\Monitor\Interfaces;

interface ShouldBeNamed
{
    /**
     * @return string
     */
    public function getName() : string;
}
