<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait useMacro
{
    protected static array $macros = [];

    public static function macro(string $name, callable $macro): void
    {
        self::$macros[$name] = $macro;
    }

    public function handleMacroCall(string $name, array $arguments): ?static
    {
        if (isset(self::$macros[$name])) {
            return call_user_func_array(self::$macros[$name]->bindTo($this, static::class), $arguments);
        }

        return null;
    }
}
