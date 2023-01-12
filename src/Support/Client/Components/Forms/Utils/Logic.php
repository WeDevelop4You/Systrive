<?php

namespace Support\Client\Components\Forms\Utils;

use Illuminate\Support\Arr;

class Logic
{
    /**
     * @var string
     */
    private string $type;

    private bool|array $returnValue;

    private function __construct(
        private readonly string $key,
        private readonly array $values,
    ) {
        //
    }

    /**
     * @param string $key
     * @param        ...$values
     *
     * @return static
     */
    public static function create(string $key, ...$values): static
    {
        return new static($key, Arr::flatten($values));
    }

    /**
     * @param mixed $trueValue
     * @param mixed $falseValue
     *
     * @return $this
     */
    public function condition(mixed $trueValue, mixed $falseValue): static
    {
        $this->type = 'condition';
        $this->returnValue = [
            'trueValue' => $trueValue,
            'falseValue' => $falseValue,
        ];

        return $this;
    }

    public function contain(bool $condition = true): static
    {
        $this->type = 'contain';
        $this->returnValue = $condition;

        return $this;
    }

    public function except(): static
    {
        return $this->contain(false);
    }

    /**
     * @return array
     */
    public function export(): array
    {
        return [
            'key' => $this->key,
            'type' => $this->type,
            'values' => $this->values,
            'returnValue' => $this->returnValue,
        ];
    }
}
