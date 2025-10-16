<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait useOverFlowBounds
{
    /**
     * ----------------------------
     * GLOBAL BOUNDS (static)
     * ----------------------------
     */
    protected static bool $globalOverflow = false;

    protected static array $globalBoundStates = [
        'month' => null,
        'day' => null,
        'weekday' => null,
        'hour' => null,
        'minute' => null,
        'second' => null,
    ];

    /**
     * ----------------------------
     * LOCAL BOUNDS (instance)
     * ----------------------------
     */
    protected ?bool $localOverflow = null;

    protected array $localBoundStates = [
        'month' => null,
        'day' => null,
        'weekday' => null,
        'hour' => null,
        'minute' => null,
        'second' => null,
    ];

    /**
     * ----------------------------
     * STRICT MODE
     * If true, local settings cannot disable globally enabled bounds.
     * ----------------------------
     */
    protected static bool $strictMode = false;

    /*==========================================================
     * GLOBAL CONTROLS
     *==========================================================*/

    public static function overflowGlobal(bool $enable = true): void
    {
        self::$globalOverflow = $enable;
    }

    public static function overflowGlobalBound(string $type, bool $enable = true): void
    {
        if (array_key_exists($type, self::$globalBoundStates)) {
            self::$globalBoundStates[$type] = $enable;
        }
    }

    public static function setStrictMode(bool $enable): void
    {
        self::$strictMode = $enable;
    }

    /*==========================================================
     * LOCAL CONTROLS (INSTANCE)
     *==========================================================*/

    public function overflowLocal(bool $enable = true): static
    {
        $instance = $this->castInstance();
        $instance->localOverflow = $enable;

        return $instance;
    }

    public function overflowBound(string $type, bool $enable = true): static
    {
        $instance = $this->castInstance();
        if (array_key_exists($type, $instance->localBoundStates)) {
            if (self::$strictMode && (self::$globalBoundStates[$type] ?? false) && ! $enable) {
                return $instance;
            }
            $instance->localBoundStates[$type] = $enable;
        }

        return $instance;
    }

    /*==========================================================
     * CHECKERS (GETTERS)
     *==========================================================*/

    /**
     * Check if a specific global bound is active.
     */
    public static function isGlobalBoundActive(string $type): bool
    {
        $state = self::$globalBoundStates[$type] ?? null;
        if ($state === null) {
            return self::$globalOverflow;
        }

        return (bool) $state;
    }

    /**
     * Get local bound state or null
     */
    public function isLocalBoundActive(string $type): ?bool
    {
        return $this->localBoundStates[$type] ?? null;
    }

    public function isOverflowActive(): bool
    {
        return $this->localOverflow ?? static::$globalOverflow;
    }

    /**
     * Check if a specific bound (month, day, etc.) is active for this instance.
     * This considers both local and global settings, respecting strict mode.
     */
    public function isBoundActive(string $type): bool
    {
        if (! array_key_exists($type, $this->localBoundStates)) {
            return false;
        }

        // If strict mode is enabled and the global bound is active, local cannot disable it
        if (static::$strictMode && static::$globalOverflow && static::isGlobalBoundActive($type)) {
            return true;
        }

        if (! $this->isOverflowActive()) {
            return false;
        }

        return $this->isLocalBoundActive($type) ?? static::isGlobalBoundActive($type);
    }

    public static function resetOverflowSettings(): void
    {
        self::$globalOverflow = false;
        self::$globalBoundStates = [
            'month' => null,
            'day' => null,
            'weekday' => null,
            'hour' => null,
            'minute' => null,
            'second' => null,
        ];

        self::$strictMode = false;
    }

    public function resetOverflow(): static
    {
        $instance = $this->castInstance();
        $instance->localOverflow = null;
        $instance->localBoundStates = [
            'month' => null,
            'day' => null,
            'weekday' => null,
            'hour' => null,
            'minute' => null,
            'second' => null,
        ];

        return $instance;
    }

    /*===========================================
     * DYNAMIC HANDLERS
     *===========================================*/

    /**
     * Handles instance dynamic calls like ->monthOverflow(true)
     */
    public function handleOverflowDynamicCall(string $method, array $arguments): ?static
    {
        if (preg_match('/^(month|day|weekday|hour|minute|second)Overflow$/', $method, $matches)) {
            $type = $matches[1];
            $value = $arguments[0] ?? true;

            return $this->overflowBound($type, (bool) $value);
        }

        return null;
    }

    /**
     * Handles static dynamic calls like ::monthOverflow(true)
     */
    public static function handleOverflowDynamicStaticCall(string $method, array $arguments): ?string
    {
        if (preg_match('/^(month|day|weekday|hour|minute|second)Overflow$/', $method, $matches)) {
            $type = $matches[1];
            $value = $arguments[0] ?? true;
            self::overflowGlobalBound($type, (bool) $value);

            return static::class;
        }

        return null;
    }
}
