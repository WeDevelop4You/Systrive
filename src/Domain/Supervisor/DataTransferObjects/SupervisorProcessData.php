<?php

namespace Domain\Supervisor\DataTransferObjects;

final class SupervisorProcessData
{
    public function __construct(
        public readonly string $name,
        public readonly string $config,
    ) {
        //
    }
}
