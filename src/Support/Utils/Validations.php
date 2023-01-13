<?php

namespace Support\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Validations
{
    /**
     * @var array
     */
    private array $additional;

    /**
     * @var array
     */
    private array $validations;

    /**
     * Validations constructor.
     *
     * @param array $validations
     * @param array $additional
     */
    public function __construct(array $validations, array $additional = [])
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
                return Collection::wrap($validations)->mapWithKeys(
                    fn (Validations $validation) => $validation->toArray("{$key}.{$suffix}")
                );
            })
            ->prepend($this->validations, $key)
            ->toArray();
    }
}
