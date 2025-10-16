<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\NepaliDateInterface;

trait useComparison
{
    public function eq(NepaliDateInterface|string $date): bool
    {
        return $this->equalTo($date);
    }

    public function equalTo(NepaliDateInterface|string $date): bool
    {
        return $this->getTimestamp() == $this->resolve($date)->getTimestamp();
    }

    public function ne(NepaliDateInterface|string $date): bool
    {
        return $this->notEqualTo($date);
    }

    public function notEqualTo(NepaliDateInterface|string $date): bool
    {
        return ! $this->equalTo($date);
    }

    public function gt(NepaliDateInterface|string $date): bool
    {
        return $this->greaterThan($date);
    }

    public function greaterThan(NepaliDateInterface|string $date): bool
    {
        return $this->getTimestamp() > $this->resolve($date)->getTimestamp();
    }

    public function isAfter(NepaliDateInterface|string $date): bool
    {
        return $this->greaterThan($date);
    }

    public function gte(NepaliDateInterface|string $date): bool
    {
        return $this->greaterThanOrEqualTo($date);
    }

    public function greaterThanOrEqualTo(NepaliDateInterface|string $date): bool
    {
        return $this->getTimestamp() >= $this->resolve($date)->getTimestamp();
    }

    public function lt(NepaliDateInterface|string $date): bool
    {
        return $this->lessThan($date);
    }

    public function lessThan(NepaliDateInterface|string $date): bool
    {
        return $this->getTimestamp() < $this->resolve($date)->getTimestamp();
    }

    public function isBefore(NepaliDateInterface|string $date): bool
    {
        return $this->lessThan($date);
    }

    public function lte(NepaliDateInterface|string $date): bool
    {
        return $this->lessThanOrEqualTo($date);
    }

    public function lessThanOrEqualTo(NepaliDateInterface|string $date): bool
    {
        return $this->getTimestamp() <= $this->resolve($date)->getTimestamp();
    }

    public function between(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2, bool $equal = true): bool
    {
        $date1 = $this->resolve($date1);
        $date2 = $this->resolve($date2);
        if ($date1->greaterThan($date2)) {
            [$date1, $date2] = [$date2, $date1];
        }
        if ($equal) {
            return $this->gte($date1) && $this->lte($date2);
        }

        return $this->gt($date1) && $this->lt($date2);
    }

    public function betweenIncluded(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2): bool
    {
        return $this->between($date1, $date2, true);
    }

    public function betweenExcluded(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2): bool
    {
        return $this->between($date1, $date2, false);
    }

    public function isBetween(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2, bool $equal = true): bool
    {
        return $this->between($date1, $date2, $equal);
    }

    public function isWeekday(): bool
    {
        return ! $this->isWeekend();
    }

    public function isWeekend(): bool
    {
        return $this->dayOfWeek == 7;
    }

    public function isYesterday(): bool
    {
        return $this->toDateString() === static::fromNotation('yesterday', $this->getTimeZone())->toDateString();
    }

    public function isToday(): bool
    {
        return $this->toDateString() === $this->nowWithSameTz()->toDateString();
    }

    public function isTomorrow(): bool
    {
        return $this->toDateString() === static::fromNotation('tomorrow', $this->getTimeZone())->toDateString();
    }

    public function isFuture(): bool
    {
        return $this->greaterThan($this->nowWithSameTz());
    }

    public function isPast(): bool
    {
        return $this->lessThan($this->nowWithSameTz());
    }

    public function isNowOrFuture(): bool
    {
        return $this->greaterThanOrEqualTo($this->nowWithSameTz());
    }

    public function isNowOrPast(): bool
    {
        return $this->lessThanOrEqualTo($this->nowWithSameTz());
    }
}
