<?php

    namespace Domain\Role\DataTransferObjects;

    final class RoleData
    {
        public function __construct(
          public string $name,
          public array $permissions
        ) {
            //
        }
    }
