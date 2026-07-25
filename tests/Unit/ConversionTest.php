<?php

use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\Traits\DateConverter;

describe('conversion', function () {
    $class = new class
    {
        use DateConverter;

        public static function callADtoBS(int $y, int $m, int $d): array
        {
            return self::ADtoBS($y, $m, $d);
        }

        public static function callBStoAD(int $y, int $m, int $d): array
        {
            return self::BStoAD($y, $m, $d);
        }
    };

    it('conver adtobs', function () use ($class) {
        $date1 = $class::callADtoBS(2025, 10, 15);
        expect($date1)->toBe([2082, 6, 29]);
        $date2 = $class::callADtoBS(2005, 3, 28);
        expect($date2)->toBe([2061, 12, 15]);
    });

    it('convert bstoad', function () use ($class) {
        $date1 = $class::callBStoAD(2082, 6, 29);
        expect($date1)->toBe([2025, 10, 15]);
        $date2 = $class::callBStoAD(2061, 12, 15);
        expect($date2)->toBe([2005, 3, 28]);
    });

    it('round-trips a representative sample of BS dates through AD and back', function () use ($class) {
        $mismatches = [];
        $assertRoundTrips = function (int $year, int $month, int $day) use ($class, &$mismatches) {
            $ad = $class::callBStoAD($year, $month, $day);
            $roundTripped = $class::callADtoBS(...$ad);

            if ($roundTripped !== [$year, $month, $day]) {
                $mismatches[] = ['bs' => [$year, $month, $day], 'ad' => $ad, 'roundTripped' => $roundTripped];
            }
        };

        for ($year = Calendar::START_YEAR_BS; $year <= Calendar::END_YEAR_BS; $year++) {
            $assertRoundTrips($year, 1, 1);
            $assertRoundTrips($year, 12, Calendar::getDaysInBSMonth($year, 12));
        }

        $sampleYears = [1900, 1950, 2000, 2050, 2082, 2100];
        foreach ($sampleYears as $year) {
            for ($month = 1; $month <= 12; $month++) {
                $daysInMonth = Calendar::getDaysInBSMonth($year, $month);
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $assertRoundTrips($year, $month, $day);
                }
            }
        }

        expect($mismatches)->toBe([]);
    });
});
