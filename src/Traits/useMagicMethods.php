<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use RohanAdhikari\NepaliDate\Exceptions\NepaliDateExceptions;

trait useMagicMethods
{
    public function __call(string $method, array $arguments)
    {
        $name = rtrim($method, 's');

        return $this->handleOverflowDynamicCall($name, $arguments)
            ?? $this->handleUnitAirthmeticDynamicCall($name, $arguments)
            ?? $this->handleSetterDynamicCall($method, $arguments)
            ?? $this->handleGetOrSetDynamicCall($name, $arguments)
            ?? $this->handleMacroCall($method, $arguments);
    }

    protected function handleGetOrSetDynamicCall(string $method, array $arguments): mixed
    {
        if (isset($arguments[0])) {
            return $this->handleDynamicSet($method, $arguments[0]);
        }

        return $this->handleDynamicGet($method);
    }

    public function __get(string $name): mixed
    {
        return $this->handleDynamicGet($name);
    }

    public function __set(string $name, mixed $value): void
    {
        if ($this->isImmutable()) {
            throw new NepaliDateExceptions('Cannot modify immutable instance. Use set method instead');
        }
        $this->handleDynamicSet($name, $value);
    }
}
