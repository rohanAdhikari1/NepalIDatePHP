<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use RohanAdhikari\NepaliDate\Constants\Calendar;
use Rohanadhikari\NepaliDate\Exceptions\NepaliDateOutOfBoundsException;
use RohanAdhikari\NepaliDate\NepaliUnit;
use RohanAdhikari\NepaliDate\NepaliWeekDay;

trait useUnitArithmetic
{
    /**
     * Unified normalization and overflow handling for setters and modifiers.
     *
     * @param  int  $value  Current or target value
     * @param  int  $max  Maximum value for the unit
     * @param  string  $unit  Unit name for bounds check
     * @param  callable  $overflowCallback  Callback for overflow
     * @return int Normalized value
     *
     * @throws NepaliDateOutOfBoundsException if overflow occurs and bounds are active
     */
    protected function normalizeOrThrow(int $value, int $max, string $unit, callable $overflowCallback, int $min = 1): int
    {
        $range = $max - $min + 1;

        $overflow = intdiv($value - $min, $range);
        if (($value - $min) < 0 && ($value - $min) % $range !== 0) {
            $overflow -= 1;
        }

        $normalized = (($value - $min) % $range + $range) % $range + $min;
        if ($overflow !== 0 && $this->isBoundActive($unit)) {
            throw new NepaliDateOutOfBoundsException("Overflow detected for unit '$unit'.");
        }
        if ($overflow !== 0) {
            $overflowCallback($overflow);
        }

        return $normalized;
    }

    protected function _modifyUnit(string $unit, int $amount): void
    {
        switch ($unit) {
            case 'year':
                $this->year += $amount;
                break;

            case 'month':
                $this->month = $this->normalizeOrThrow($this->month + $amount, 12, 'month', fn ($overflow) => $this->_modifyUnit('year', $overflow));
                break;

            case 'day':
                $daysInMonth = Calendar::getDaysInBSMonth($this->year, $this->month);
                $this->day = $this->normalizeOrThrow($this->day + $amount, $daysInMonth, 'day', fn ($overflow) => $this->_modifyUnit('month', $overflow));
                break;

            case 'hour':
                $this->hour = $this->normalizeOrThrow($this->hour + $amount, 23, 'hour', fn ($overflow) => $this->_modifyUnit('day', $overflow), 0);
                break;

            case 'minute':
                $this->minute = $this->normalizeOrThrow($this->minute + $amount, 59, 'minute', fn ($overflow) => $this->_modifyUnit('hour', $overflow), 0);
                break;

            case 'second':
                $this->second = $this->normalizeOrThrow($this->second + $amount, 59, 'second', fn ($overflow) => $this->_modifyUnit('minute', $overflow), 0);
                break;

            default:
                throw new \InvalidArgumentException("Unknown unit '$unit'.");
        }
    }

    /**
     * Generic unit modifier.
     *
     * @param  string  $unit  Unit name ('year', 'month', 'day', etc.)
     * @param  int  $amount  Amount to modify
     */
    public function modifyUnit(string|NepaliUnit $unit, int $amount): static
    {
        $unit = NepaliUnit::toName($unit);
        $instance = $this->castInstance();
        $instance->_modifyUnit($unit, $amount);
        $instance->setDayOfWeek();

        return $instance;
    }

    public function shiftToNearWeek(int|NepaliWeekDay $weekday, bool $up = true): static
    {
        $weekday = NepaliWeekDay::int($weekday);
        $instance = $this->castInstance();
        $diff = $instance->dayOfWeek;
        if ($diff === 0) {
            return $instance;
        }
        if ($up) {
            if ($diff < 0) {
                $diff += 7;
            }
        } else {
            if ($diff > 0) {
                $diff -= 7;
            }
        }

        return $instance->addDays($diff);
    }

    /**
     * @param  array<mixed>  $arguments
     */
    public function handleUnitAirthmeticDynamicCall(string $method, array $arguments): ?static
    {
        if (! preg_match('/^(add|sub)(Year|Month|Day|Hour|Minute|Second)$/', $method, $matches)) {
            return null;
        }
        $operation = $matches[1];
        $unit = strtolower($matches[2]);
        if (! isset($arguments[0])) {
            throw new \InvalidArgumentException("Missing argument for $method");
        }
        $value = (int) $arguments[0];
        if ($operation === 'sub') {
            $value = -$value;
        }

        return $this->modifyUnit($unit, $value);
    }
}
