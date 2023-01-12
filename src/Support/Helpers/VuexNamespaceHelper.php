<?php

namespace Support\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class VuexNamespaceHelper
{
    /**
     * VuexNamespaceHelper constructor.
     *
     * @param Stringable $namespace
     */
    private function __construct(
        private Stringable $namespace
    ) {
        //
    }

    /**
     * @param string $namespace
     *
     * @return static
     */
    public static function create(string $namespace): static
    {
        return new static(Str::of($namespace));
    }

    /**
     * @param string $namespace
     *
     * @return static
     */
    public static function createCompanyWhenAdmin(string $namespace): static
    {
        return self::create($namespace)->addPrefixWhenAdmin('company');
    }

    /**
     * @param string $prefix
     * @param bool   $condition
     *
     * @return $this
     */
    public function addPrefixIf(string $prefix, bool $condition): static
    {
        if ($condition) {
            $this->namespace = $this->namespace->prepend($prefix, '/');
        }

        return $this;
    }

    /**
     * @param $prefix
     *
     * @return $this
     */
    public function addPrefixWhenAdmin($prefix): static
    {
        return $this->addPrefixIf($prefix, ApplicationHelper::isAdminDomain());
    }

    /**
     * @return string
     */
    public function export(): string
    {
        return $this->namespace->value();
    }
}
