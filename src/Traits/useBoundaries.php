<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use Rohanadhikari\NepaliDate\Exceptions\NepaliDateExceptions;
use Rohanadhikari\NepaliDate\Exceptions\NepaliDateUnknownUnitException;
use RohanAdhikari\NepaliDate\NepaliUnit;
use RohanAdhikari\NepaliDate\NepaliWeekDay;

trait useBoundaries
{
    public function startOfDay(): static
    {
        return $this->setTime(0, 0, 0);
    }

    public function endOfDay(): static
    {
        return $this->setTime(23, 59, 59);
    }

    public function startOfMonth(): static
    {
        return $this->setDay(1)->startOfDay();
    }

    public function endOfMonth(): static
    {
        return $this->setDay($this->daysInMonth)->endOfDay();
    }

    public function startOfQuarter(): static
    {
        $month = ($this->quarter - 1) * 3 + 1;

        return $this->setMonth($month)->startOfMonth();
    }

    public function endOfQuarter(): static
    {
        $month = $this->quarter * 3;

        return $this->setMonth($month)->endOfMonth();
    }

    public function startOfYear(): static
    {
        return $this->setMonth(1)->startOfMonth();
    }

    public function endOfYear(): static
    {
        return $this->setMonth(12)->endOfMonth();
    }

    public function startOfDecade(): static
    {
        $year = $this->year - ($this->year % 10);

        return $this->setYear($year)->startOfYear();
    }

    public function endOfDecade(): static
    {
        $year = $this->year - ($this->year % 10) + 9;

        return $this->setYear($year)->endOfYear();
    }

    public function startOfCentury(): static
    {
        $year = $this->year - ($this->year - 1) % 100;

        return $this->setYear($year)->startOfYear();
    }

    public function endOfCentury(): static
    {
        $year = $this->year - 1 - ($this->year - 1) % 100 + 100;

        return $this->setYear($year)->endOfYear();
    }

    public function startOfMillennium(): static
    {
        $year = $this->year - ($this->year - 1) % 1000;

        return $this->setYear($year)->startOfYear();
    }

    public function endOfMillennium(): static
    {
        $year = $this->year - 1 - ($this->year - 1) % 100 + 100;

        return $this->setYear($year)->endOfYear();
    }

    public function startOfWeek(NepaliWeekDay|int|null $weekStartsAt = null): static
    {
        $weekStartsAt = NepaliWeekDay::int($weekStartsAt) ?? 1;
        $currentDay = $this->dayOfWeek;
        $daysToSubtract = ($currentDay - $weekStartsAt + 7) % 7;

        return $this
            ->subDays($daysToSubtract)
            ->startOfDay();
    }

    public function endOfWeek(NepaliWeekDay|int|null $weekEndsAt = null): static
    {
        $weekEndsAt = NepaliWeekDay::int($weekEndsAt) ?? 7;
        $currentDay = $this->dayOfWeek;
        $daysToAdd = ($weekEndsAt - $currentDay + 7) % 7;

        return $this
            ->addDays($daysToAdd)
            ->endOfDay();
    }

    public function startOfHour(): static
    {
        return $this->setTime($this->hour, 0, 0);
    }

    public function endOfHour(): static
    {
        return $this->setTime($this->hour, 59, 59);
    }

    public function startOfMinute(): static
    {
        return $this->setSecond(0);
    }

    public function endOfMinute(): static
    {
        return $this->setSecond(59);
    }

    public function startOf(NepaliUnit|string $unit, mixed ...$params): static
    {
        $ucfUnit = ucfirst(NepaliUnit::toName($unit));
        if ($ucfUnit == 'Second') {
            throw new NepaliDateExceptions('Second Unit is not supported for startOf method.');
        }
        $method = "startOf$ucfUnit";
        if (! method_exists($this, $method)) {
            throw new NepaliDateUnknownUnitException($unit);
        }

        return $this->$method(...$params);
    }

    public function endOf(NepaliUnit|string $unit, mixed ...$params): static
    {
        $ucfUnit = ucfirst(NepaliUnit::toName($unit));
        if ($ucfUnit == 'Second') {
            throw new NepaliDateExceptions('Second Unit is not supported for endOf method.');
        }
        $method = "endOf$ucfUnit";
        if (! method_exists($this, $method)) {
            throw new NepaliDateUnknownUnitException($unit);
        }

        return $this->$method(...$params);
    }
}
