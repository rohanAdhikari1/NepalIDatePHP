<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait haveMonthOverflow
{
    /**
     * Global month overflow behavior.
     */
    protected static bool $monthsOverflow = true;

    /**
     * Instance month overflow override.
     *
     * null = use global setting.
     */
    protected ?bool $localMonthsOverflow = null;

    /**
     * Enable/disable global month overflow.
     */
    public static function useMonthsOverflow(bool $overflow = true): void
    {
        static::$monthsOverflow = $overflow;
    }

    /**
     * Enable month overflow globally.
     */
    public static function enableMonthsOverflow(): void
    {
        static::$monthsOverflow = true;
    }

    /**
     * Disable month overflow globally.
     */
    public static function disableMonthsOverflow(): void
    {
        static::$monthsOverflow = false;
    }

    /**
     * Returns the global overflow configuration.
     */
    public static function shouldOverflowMonthsGlobally(): bool
    {
        return static::$monthsOverflow;
    }

    /**
     * Set month overflow for this instance.
     *
     * null removes the override and falls back to the global setting.
     */
    public function setMonthsOverflow(?bool $overflow): static
    {
        $this->localMonthsOverflow = $overflow;

        return $this;
    }

    /**
     * Returns the effective month overflow configuration.
     */
    protected function shouldOverflowMonths(): bool
    {
        return $this->localMonthsOverflow ?? static::$monthsOverflow;
    }

    /**
     * Returns whether this instance has its own overflow setting.
     */
    public function hasLocalMonthsOverflow(): bool
    {
        return $this->localMonthsOverflow !== null;
    }

    /**
     * Returns the local overflow setting.
     */
    public function getLocalMonthsOverflow(): ?bool
    {
        return $this->localMonthsOverflow;
    }

    /**
     * Clears the instance override.
     */
    public function resetMonthsOverflow(): static
    {
        $this->localMonthsOverflow = null;

        return $this;
    }
}
