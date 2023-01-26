<?php

namespace Support\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\NestedRules;

class Validations
{
    /**
     * @var array
     */
    private array $additional;

    /**
     * @var array|NestedRules
     */
    private array|NestedRules $validations;

    /**
     * Validations constructor.
     *
     * @param array|NestedRules $validations
     * @param array             $additional
     */
    public function __construct(array|NestedRules $validations, array $additional = [])
    {
        $this->validations = $validations;
        $this->additional = Arr::dot($additional);
    }

    /**
     * @param Validations $validations
     *
     * @return $this
     */
    public function add(Validations $validations): static
    {
        $this->additional = array_merge($this->additional, $validations->getAdditional());
        $this->validations = array_merge($this->validations, $validations->getValidations());

        return $this;
    }

    /**
     * @return array
     */
    public function getAdditional(): array
    {
        return $this->additional;
    }

    /**
     * @return array
     */
    public function getValidations(): array
    {
        return $this->validations;
    }

    /**
     * @param string $key
     *
     * @return array
     */
    public function toArray(string $key): array
    {
        return Collection::make($this->additional)
            ->mapWithKeys(function ($validations, string $suffix) use ($key) {
                return Collection::wrap($validations)
                    ->mapWithKeys(function (Validations|NestedRules $validation) use ($key, $suffix) {
                        if ($validation instanceof Validations) {
                            return $validation->toArray("{$key}.{$suffix}");
                        }

                        return ["{$key}.{$suffix}" => $validation];
                    });
            })
            ->prepend($this->validations, $key)
            ->toArray();
    }
}
