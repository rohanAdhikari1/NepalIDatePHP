<?php

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
});
