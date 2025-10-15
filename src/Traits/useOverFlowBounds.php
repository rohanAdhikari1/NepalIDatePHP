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
        'month' => true,
        'day' => true,
        'weekday' => true,
        'hour' => true,
        'minute' => true,
        'second' => true,
    ];

    /**
     * ----------------------------
     * LOCAL BOUNDS (instance)
     * ----------------------------
     */
    protected bool $localOverflow = false;

    protected array $localBoundStates = [
        'month' => true,
        'day' => true,
        'weekday' => true,
        'hour' => true,
        'minute' => true,
        'second' => true,
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
        $this->localOverflow = $enable;

        return $this;
    }

    public function overflowBound(string $type, bool $enable = true): static
    {
        if (array_key_exists($type, $this->localBoundStates)) {
            if (self::$strictMode && (self::$globalBoundStates[$type] ?? false) && ! $enable) {
                return $this;
            }
            $this->localBoundStates[$type] = $enable;
        }

        return $this;
    }

    /*==========================================================
     * CHECKERS (GETTERS)
     *==========================================================*/

    /**
     * Check if a specific global bound is active.
     */
    public static function isGlobalBoundActive(string $type): bool
    {
        return self::$globalOverflow && (self::$globalBoundStates[$type] ?? false);
    }

    /**
     * Check if a specific local bound is active.
     */
    public function isLocalBoundActive(string $type): bool
    {
        return $this->localOverflow && ($this->localBoundStates[$type] ?? false);
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
        if (self::$strictMode && self::isGlobalBoundActive($type)) {
            return true;
        }

        // Otherwise, fall back to local overflow settings
        return self::isGlobalBoundActive($type) || $this->isLocalBoundActive($type);
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
