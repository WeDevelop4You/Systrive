<?php

namespace Support\Graphql\Enums;

use Illuminate\Support\Str;
use Support\Graphql\Definitions\Types\EnumType;

class SortingDirectionEnum extends EnumType
{
    public function __construct(
        private readonly string|null $suffix = null,
    ) {
        //
    }

    /**
     * {@inheritDoc}
     */
    protected function name(): string
    {
        $name = Str::of('SortingDirection');

        if (!is_null($this->suffix)) {
            $name = $name->append('For', ucfirst($this->suffix));
        }

        return $name->toString();
    }

    /**
     * {@inheritDoc}
     */
    protected function values(): array
    {
        return [
            'asc' => 'asc',
            'desc' => 'desc',
        ];
    }
}
