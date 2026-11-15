<?php

declare(strict_types=1);

namespace Tests\Support;

use RohanAdhikari\NepaliDate\Constants\Calendar;

/**
 * Test-only copy of the v2.0-beta converter, which walked a month at a time from the
 * 1900 BS / 1843 AD anchor. Kept as an independent reference for the year-jump converter.
 * Uses only Calendar's raw data (NEPALI_DATES, month lengths), never its day-number helpers.
 */
final class LegacyMonthWalkConverter
{
    /**
     * @return array{int,int,int}
     */
    public static function adToBs(int $year, int $month, int $day): array
    {
        return self::walk(
            Calendar::START_YEAR_BS,
            Calendar::START_MONTH_BS,
            Calendar::START_DAY_BS - 1,
            self::totalAdDays($year, $month, $day),
            Calendar::getDaysInBSMonth(...)
        );
    }

    /**
     * @return array{int,int,int}
     */
    public static function bsToAd(int $year, int $month, int $day): array
    {
        return self::walk(
            Calendar::START_YEAR_AD,
            Calendar::START_MONTH_AD,
            Calendar::START_DAY_AD - 1,
            self::totalBsDays($year, $month, $day),
            Calendar::getDaysInADMonth(...)
        );
    }

    private static function totalBsDays(int $year, int $month, int $day): int
    {
        $total = 0;
        for ($y = Calendar::BASE_YEAR_BS; $y < $year; $y++) {
            $total += array_sum(Calendar::NEPALI_DATES[$y]);
        }

        return $total + array_sum(array_slice(Calendar::NEPALI_DATES[$year], 0, $month - 1)) + $day;
    }

    private static function totalAdDays(int $year, int $month, int $day): int
    {
        if ($year === Calendar::START_YEAR_AD) {
            $total = -(Calendar::isLeapYear($year) ? 366 : 365);
        } else {
            $total = 0;
            for ($y = Calendar::BASE_YEAR_AD; $y < $year; $y++) {
                $total += Calendar::isLeapYear($y) ? 366 : 365;
            }
        }
        $months = Calendar::isLeapYear($year) ? Calendar::LEAP_MONTHS : Calendar::NORMAL_MONTHS;

        return $total + array_sum(array_slice($months, 0, $month - 1)) + $day;
    }

    /**
     * @return array{int,int,int}
     */
    private static function walk(int $year, int $month, int $day, int $steps, \Closure $daysInMonth): array
    {
        if ($steps >= 0) {
            while (true) {
                $untilRollover = $daysInMonth($year, $month) - $day + 1;
                if ($steps < $untilRollover) {
                    return [$year, $month, $day + $steps];
                }
                $steps -= $untilRollover;
                $day = 1;
                if (++$month > 12) {
                    $month = 1;
                    $year++;
                }
            }
        }

        $steps = -$steps;
        while (true) {
            if ($steps < $day) {
                return [$year, $month, $day - $steps];
            }
            $steps -= $day;
            if (--$month < 1) {
                $month = 12;
                $year--;
            }
            $day = $daysInMonth($year, $month);
        }
    }
}
