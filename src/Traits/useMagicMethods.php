<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait useMagicMethods
{
    public function __call(string $method, array $arguments)
    {
        $name = rtrim($method, 's');

        return $this->handleOverflowDynamicCall($name, $arguments)
            ?? $this->handleUnitAirthmeticDynamicCall($name, $arguments)
            ?? $this->handleSetterDynamicCall($name, $arguments)
            ?? $this->handleMacroCall($method, $arguments);
    }

    public function __get(string $name)
    {
        return $this->handleDynamicGet($name);
    }
}
