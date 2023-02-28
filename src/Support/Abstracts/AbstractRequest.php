<?php

namespace Support\Abstracts;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    /**
     * @return array
     */
    final public function rules(): array
    {
        return array_merge_recursive(
            $this->defaultRules(),
            $this->otherRules()
        );
    }

    /**
     * @return bool
     */
    protected function isUpdating(): bool
    {
        return \in_array($this->getMethod(), ['PATCH', 'PUT']);
    }

    private function otherRules(): array
    {
        return $this->isUpdating()
            ? $this->updateRules()
            : $this->storeRules();
    }

    /**
     * @return array
     */
    abstract protected function defaultRules(): array;

    /**
     * @return array
     */
    abstract protected function storeRules(): array;

    /**
     * @return array
     */
    abstract protected function updateRules(): array;
}
