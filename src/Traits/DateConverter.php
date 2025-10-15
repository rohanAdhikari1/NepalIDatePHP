<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

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
        $bsYear = Calendar::START_YEAR_BS;
        $bsMonth = Calendar::START_MONTH_BS;
        $bsDay = Calendar::START_DAY_BS - 1;
        for ($i = 0; $i < $totalDays; $i++) {
            $bsDay++;
            if ($bsDay > Calendar::getDaysInBSMonth($bsYear, $bsMonth)) {
                $bsMonth++;
                $bsDay = 1;
                if ($bsMonth > 12) {
                    $bsYear++;
                    $bsMonth = 1;
                }
            }
        }

        return [$bsYear, $bsMonth, $bsDay];
    }

    /**
     * @return array{int,int,int} [year, month, day]
     */
    protected static function BStoAD(int $year, int $month, int $day): array
    {
        self::validateBsDate($year, $month, $day);
        $totalDays = Calendar::getTotalBSDays($year, $month, $day);
        $adYear = Calendar::START_YEAR_AD;
        $adMonth = Calendar::START_MONTH_AD;
        $adDay = Calendar::START_DAY_AD - 1;
        for ($i = 0; $i < $totalDays; $i++) {
            $adDay++;
            if ($adDay > Calendar::getDaysInADMonth($adYear, $adMonth)) {
                $adMonth++;
                $adDay = 1;
                if ($adMonth > 12) {
                    $adYear++;
                    $adMonth = 1;
                }
            }
        }

        return [$adYear, $adMonth, $adDay];
    }
}
