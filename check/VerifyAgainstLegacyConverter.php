<?php

/**
 * Compares the converter with the previous month-walk converter (tests/Support/LegacyMonthWalkConverter.php)
 * for EVERY day of the supported range, in both directions. Takes ~30 s, so it is not part of `composer test`;
 * run it by hand after touching Calendar.php or DateConverter.php:
 *
 *     php check/VerifyAgainstLegacyConverter.php
 */

require __DIR__.'/../vendor/autoload.php';

use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\Traits\DateConverter;
use Tests\Support\LegacyMonthWalkConverter;

$converter = new class
{
    use DateConverter;

    public static function toBs(int $y, int $m, int $d): array
    {
        return self::ADtoBS($y, $m, $d);
    }

    public static function toAd(int $y, int $m, int $d): array
    {
        return self::BStoAD($y, $m, $d);
    }
};

$start = microtime(true);
$checked = 0;
$mismatches = [];

for ($year = Calendar::START_YEAR_BS; $year <= Calendar::END_YEAR_BS; $year++) {
    for ($month = 1; $month <= 12; $month++) {
        $daysInMonth = Calendar::getDaysInBSMonth($year, $month);
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $checked++;
            if ($converter::toAd($year, $month, $day) !== LegacyMonthWalkConverter::bsToAd($year, $month, $day)) {
                $mismatches[] = "BS $year-$month-$day";
            }
        }
    }
}

for ($date = new DateTimeImmutable('1843-01-01'); $date <= new DateTimeImmutable('2044-12-31'); $date = $date->modify('+1 day')) {
    [$year, $month, $day] = array_map('intval', explode('-', $date->format('Y-n-j')));
    $checked++;
    if ($converter::toBs($year, $month, $day) !== LegacyMonthWalkConverter::adToBs($year, $month, $day)) {
        $mismatches[] = "AD $year-$month-$day";
    }
}

printf("Checked %s dates in %.1f s: %d mismatches\n", number_format($checked), microtime(true) - $start, count($mismatches));
foreach (array_slice($mismatches, 0, 20) as $mismatch) {
    echo "  $mismatch\n";
}

exit($mismatches === [] ? 0 : 1);
