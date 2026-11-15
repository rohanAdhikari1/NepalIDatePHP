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

        return Calendar::bsDateFromDayNumber(Calendar::adDayNumber($year, $month, $day));
    }

    /**
     * @return array{int,int,int} [year, month, day]
     */
    protected static function BStoAD(int $year, int $month, int $day): array
    {
        self::validateBsDate($year, $month, $day);

        return Calendar::adDateFromDayNumber(Calendar::bsDayNumber($year, $month, $day));
    }
}
