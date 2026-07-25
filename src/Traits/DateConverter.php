<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use Closure;
use RohanAdhikari\NepaliDate\Constants\Calendar;

trait DateConverter
{
    use useValidator;

    /**
     * @return array{int,int,int} [year, month, day]
     */
    protected static function ADtoBS(int $year, int $month, int $day): array
    {
        self::validateAdDate($year, $month, $day);
        $totalDays = Calendar::getTotalADDays($year, $month, $day);

        return self::walkFromAnchor(
            Calendar::START_YEAR_BS,
            Calendar::START_MONTH_BS,
            Calendar::START_DAY_BS - 1,
            $totalDays,
            Calendar::getDaysInBSMonth(...)
        );
    }

    /**
     * @return array{int,int,int} [year, month, day]
     */
    protected static function BStoAD(int $year, int $month, int $day): array
    {
        self::validateBsDate($year, $month, $day);
        $totalDays = Calendar::getTotalBSDays($year, $month, $day);

        return self::walkFromAnchor(
            Calendar::START_YEAR_AD,
            Calendar::START_MONTH_AD,
            Calendar::START_DAY_AD - 1,
            $totalDays,
            Calendar::getDaysInADMonth(...)
        );
    }

    /**
     * A negative count only ever occurs converting AD dates that fall in
     * {@see Calendar::START_YEAR_AD}, the one AD
     * year that starts before the day-counting epoch used by getTotalADDays().
     *
     * @return array{int,int,int} [year, month, day]
     */
    private static function walkFromAnchor(int $year, int $month, int $day, int $steps, Closure $daysInMonth): array
    {
        return $steps >= 0
            ? self::stepForward($year, $month, $day, $steps, $daysInMonth)
            : self::stepBackward($year, $month, $day, -$steps, $daysInMonth);
    }

    /**
     * @return array{int,int,int} [year, month, day]
     */
    private static function stepForward(int $year, int $month, int $day, int $remainingDays, Closure $daysInMonth): array
    {
        while (true) {
            $daysUntilRollover = $daysInMonth($year, $month) - $day + 1;

            if ($remainingDays < $daysUntilRollover) {
                return [$year, $month, $day + $remainingDays];
            }

            $remainingDays -= $daysUntilRollover;
            $day = 1;
            $month++;
            if ($month > 12) {
                $month = 1;
                $year++;
            }
        }
    }

    /**
     * @return array{int,int,int} [year, month, day]
     */
    private static function stepBackward(int $year, int $month, int $day, int $remainingDays, Closure $daysInMonth): array
    {
        while (true) {
            if ($remainingDays < $day) {
                return [$year, $month, $day - $remainingDays];
            }

            $remainingDays -= $day;
            $month--;
            if ($month < 1) {
                $month = 12;
                $year--;
            }
            $day = $daysInMonth($year, $month);
        }
    }
}
