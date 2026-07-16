<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use DateTimeZone;
use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\Exceptions\NepaliDateOutOfBoundsException;
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
        $offset = $value - $min;
        $overflow = intdiv($offset, $range);
        if ($offset < 0 && $offset % $range !== 0) {
            $overflow--;
        }
        $this->assertNoOverflowIfBound($overflow !== 0, $unit);
        if ($overflow !== 0) {
            $overflowCallback($overflow);
        }

        return ($offset % $range + $range) % $range + $min;
    }

    /**
     * Normalize a value for a VARIABLE-capacity unit — one whose range depends
     * on the state of a containing unit (e.g. days-in-month depends on which
     * year and month it is). Because the range can change after every step,
     * this cannot be resolved with a single division like
     * {@see normalizeOrThrow()}; it must re-resolve the range after each step
     * into the containing unit and carry the remainder across.
     *
     * This is intentionally generic and reusable: any unit with a
     * state-dependent capacity can be normalized by passing a resolver for
     * "what's the current max?" and an advancer for "move the containing
     * unit by one step".
     *
     * @param  int  $value  Current or target value
     * @param  int  $min  Minimum value for the unit
     * @param  string  $unit  Unit name for bounds check
     * @param  callable(): int  $rangeResolver  Returns the current max (inclusive), given current state
     * @param  callable(int): void  $advance  Moves the containing unit by +1 or -1 step
     * @return int Normalized value
     *
     * @throws NepaliDateOutOfBoundsException if overflow occurs and bounds are active
     */
    protected function normalizeVariableRange(int $value, int $min, string $unit, callable $rangeResolver, callable $advance): int
    {
        $max = $rangeResolver();

        $this->assertNoOverflowIfBound($value < $min || $value > $max, $unit);

        while ($value > $max) {
            $value -= ($max - $min + 1);
            $advance(1);
            $max = $rangeResolver();
        }

        while ($value < $min) {
            $advance(-1);
            $max = $rangeResolver();
            $value += ($max - $min + 1);
        }

        return $value;
    }

    protected function assertNoOverflowIfBound(bool $wouldOverflow, string $unit): void
    {
        if ($wouldOverflow && $this->isBoundActive($unit)) {
            throw new NepaliDateOutOfBoundsException("Overflow detected for unit '$unit'.");
        }
    }

    protected function shiftMonthOnly(int $delta): void
    {
        $this->month = $this->normalizeOrThrow($this->month + $delta, 12, 'month', fn($overflow) => $this->_modifyUnit('year', $overflow));
    }

    protected function addDaysRaw(int $amount): void
    {
        $this->day = $this->normalizeVariableRange(
            $this->day + $amount,
            1,
            'day',
            fn(): int => Calendar::getDaysInBSMonth($this->year, $this->month),
            fn(int $direction) => $this->shiftMonthOnly($direction),
        );
    }

    protected function _modifyUnit(string $unit, int $amount, ?bool $monthOverflow = null): void
    {
        switch ($unit) {
            case 'year':
                $this->year += $amount;
                break;

            case 'month':
                $this->month = $this->normalizeOrThrow($this->month + $amount, 12, 'month', fn($overflow) => $this->_modifyUnit('year', $overflow));
                $this->adjustDayAfterMonthChange($monthOverflow);
                break;

            case 'day':
                $this->addDaysRaw($amount);
                break;

            case 'hour':
                $this->hour = $this->normalizeOrThrow($this->hour + $amount, 23, 'hour', fn($overflow) => $this->_modifyUnit('day', $overflow), 0);
                break;

            case 'minute':
                $this->minute = $this->normalizeOrThrow($this->minute + $amount, 59, 'minute', fn($overflow) => $this->_modifyUnit('hour', $overflow), 0);
                break;

            case 'second':
                $this->second = $this->normalizeOrThrow($this->second + $amount, 59, 'second', fn($overflow) => $this->_modifyUnit('minute', $overflow), 0);
                break;

            default:
                throw new \InvalidArgumentException("unit '$unit' not supported.");
        }
    }

    protected function adjustDayAfterMonthChange(?bool $monthOverflow): void
    {
        $monthOverflow ??= $this->shouldOverflowMonths();
        $daysInMonth = Calendar::getDaysInBSMonth($this->year, $this->month);
        if ($this->day <= $daysInMonth) {
            return;
        }
        if ($monthOverflow) {
            $overflow = $this->day - $daysInMonth;
            $this->day = $daysInMonth;
            $this->_modifyUnit('day', $overflow);
        } else {
            $this->day = $daysInMonth;
        }
    }

    /**
     * Generic unit modifier.
     *
     * @param  string  $unit  Unit name ('year', 'month', 'day', etc.)
     * @param  int  $amount  Amount to modify
     * @param  bool|null  $monthOverflow  null = use default setting,
     *                                    true = with overflow,
     *                                    false = no overflow.
     */
    public function modifyUnit(string|NepaliUnit $unit, int $amount, ?bool $monthOverflow = null): static
    {
        $unit = NepaliUnit::toName($unit);
        $instance = $this->castInstance();
        $instance->_modifyUnit($unit, $amount, $monthOverflow);
        $instance->setDayOfWeek();

        return $instance;
    }

    public function shiftToNearWeek(int|NepaliWeekDay $weekday, bool $up = true): static
    {
        $weekday = NepaliWeekDay::int($weekday);
        $instance = $this->castInstance();
        $diff = $weekday - $instance->dayOfWeek;
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

    public function shiftTimezone(DateTimeZone|string $timezone): static
    {
        $instance = $this->castInstance();
        $oldtimezoneOffset = (int) $instance->format('Z');
        $instance->setTimezone($timezone);
        $newtimezoneOffset = (int) $instance->format('Z');
        $offsetdiff = $newtimezoneOffset - $oldtimezoneOffset;
        $instance->_modifyUnit('second', $offsetdiff);
        $instance->setDayOfWeek();

        return $instance;
    }

    /**
     * @param  array<mixed>  $arguments
     */
    public function handleUnitAirthmeticDynamicCall(string $method, array $arguments): ?static
    {
        if (! preg_match('/^(add|sub)(Year|Month|Day|Hour|Minute|Second)s?(WithOverflow|NoOverflow)?$/', $method, $matches)) {
            return null;
        }
        $operation = $matches[1];
        $unit = strtolower($matches[2]);
        $overflow = $matches[3] ?? '';
        $requiresArgument = str_ends_with($method, 's');
        if ($requiresArgument && ! isset($arguments[0])) {
            throw new \InvalidArgumentException("Missing argument for $method");
        }
        $value = isset($arguments[0]) ? (int) $arguments[0] : 1;
        if ($operation === 'sub') {
            $value = -$value;
        }
        $monthOverflow = match ($overflow) {
            'WithOverflow' => true,
            'NoOverflow' => false,
            default => null,
        };

        return $this->modifyUnit($unit, $value, $monthOverflow);
    }
}
