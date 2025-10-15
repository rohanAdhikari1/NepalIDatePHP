<?php

declare(strict_types=1);

namespace Rohanadhikari\NepaliDate\Traits;

use RohanAdhikari\NepaliDate\Constants\Calendar;
use Rohanadhikari\NepaliDate\Exceptions\NepaliDateOutOfBoundsException;

trait useValidator
{
    public static function isvalidMinuteOrSecond(int $value): bool
    {
        return $value >= 0 && $value <= 59;
    }

    public static function isvalidHour(int $value): bool
    {
        return $value >= 0 && $value <= 23;
    }

    public static function isvalidDayOfWeek(int $value): bool
    {
        return $value >= 1 && $value <= 7;
    }

    public static function isvalidMonth(int $value): bool
    {
        return $value >= 1 && $value <= 12;
    }

    public static function isvalidBsYear(int $year): bool
    {
        return $year >= Calendar::START_YEAR_BS && $year <= Calendar::END_YEAR_BS;
    }

    public static function isvalidAdYear(int $year): bool
    {
        return $year >= Calendar::START_YEAR_AD && $year <= Calendar::START_YEAR_AD + (Calendar::END_YEAR_BS - Calendar::START_YEAR_BS);
    }

    public static function isvalidBsDay(int $year, int $month, int $day): bool
    {
        $daysInMonth = Calendar::getDaysInBSMonth($year, $month);

        return $day >= 1 && $day <= $daysInMonth;
    }

    public static function isvalidAdDay(int $year, int $month, int $day): bool
    {
        $daysInMonth = Calendar::getDaysInADMonth($year, $month);

        return $day >= 1 && $day <= $daysInMonth;
    }

    public static function isValidAdDate(int $year, int $month, int $day): bool
    {
        return self::isvalidAdYear($year) && self::isvalidMonth($month) && self::isvalidAdDay($year, $month, $day);
    }

    public static function isValidBsDate(int $year, int $month, int $day): bool
    {
        return self::isvalidBsYear($year) && self::isvalidMonth($month) && self::isvalidBsDay($year, $month, $day);
    }

    public static function validateAdDate(int $year, int $month, int $day): void
    {
        if (! self::isvalidAdYear($year)) {
            throw new NepaliDateOutOfBoundsException("Invalid AD year: $year. Valid range is ".Calendar::START_YEAR_AD.' to '.(Calendar::START_DAY_AD + (Calendar::END_YEAR_BS - Calendar::START_YEAR_BS)).'.');
        }
        if (! self::isvalidMonth($month)) {
            throw new NepaliDateOutOfBoundsException("Invalid month: $month. Valid range is 1 to 12.");
        }
        if (! self::isvalidAdDay($year, $month, $day)) {
            $daysInMonth = Calendar::getDaysInADMonth($year, $month);
            throw new NepaliDateOutOfBoundsException("Invalid day: $day for month: $month and year: $year. Valid range is 1 to $daysInMonth.");
        }
    }

    public static function validateBSYear(int $year): void
    {
        if (! self::isvalidBsYear($year)) {
            throw new NepaliDateOutOfBoundsException("Invalid BS year: $year. Valid range is ".Calendar::START_YEAR_BS.' to '.Calendar::END_YEAR_BS.'.');
        }
    }

    public static function validateBsDate(int $year, int $month, int $day): void
    {
        self::validateBSYear($year);
        if (! self::isvalidMonth($month)) {
            throw new NepaliDateOutOfBoundsException("Invalid month: $month. Valid range is 1 to 12.");
        }
        if (! self::isvalidBsDay($year, $month, $day)) {
            $daysInMonth = Calendar::getDaysInBSMonth($year, $month);
            throw new NepaliDateOutOfBoundsException("Invalid day: $day for month: $month and year: $year. Valid range is 1 to $daysInMonth.");
        }
    }
}
