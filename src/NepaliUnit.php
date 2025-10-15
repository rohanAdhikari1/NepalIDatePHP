<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate;

enum NepaliUnit: string
{
    case Second = 'second';
    case Minute = 'minute';
    case Hour = 'hour';
    case Day = 'day';
    case Week = 'week';
    case Month = 'month';
    case Quarter = 'quarter';
    case Year = 'year';
    case Decade = 'decade';
    case Century = 'century';
    case Millennium = 'millennium';

    public static function toName(self|string $unit): string
    {
        return $unit instanceof self ? $unit->value : $unit;
    }
}
