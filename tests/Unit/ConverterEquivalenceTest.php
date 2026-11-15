<?php

use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\Exceptions\NepaliDateOutOfBoundsException;
use RohanAdhikari\NepaliDate\NepaliDate;
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

/**
 * Walks every AD day from 1843-01-01 to 2044-12-31 (the whole supported AD range) in lockstep
 * with a BS date advanced one day at a time from NEPALI_DATES. DateTime supplies the AD side and
 * the weekday, so this oracle shares no arithmetic with the code under test.
 *
 * @param  callable(array{int,int,int} $ad, array{int,int,int} $bs, int $weekday): void  $visit  weekday: 1 = Sunday
 */
function walkEveryDay(callable $visit): void
{
    $ad = new DateTimeImmutable('1843-01-01');
    $end = new DateTimeImmutable('2044-12-31');
    $bs = [1899, 9, 18]; // 1843-01-01 AD, as given by the original day-by-day v1 converter

    while ($ad <= $end) {
        [$y, $m, $d, $w] = array_map('intval', explode('-', $ad->format('Y-n-j-w')));
        $visit([$y, $m, $d], $bs, $w + 1);

        $ad = $ad->modify('+1 day');
        if (++$bs[2] > Calendar::NEPALI_DATES[$bs[0]][$bs[1] - 1]) {
            $bs[2] = 1;
            if (++$bs[1] > 12) {
                $bs[1] = 1;
                $bs[0]++;
            }
        }
    }
}

describe('year-jump converter', function () use ($converter) {
    it('matches a day-by-day walk for every day, in both directions, with the right weekday', function () use ($converter) {
        $mismatches = [];
        $days = 0;
        walkEveryDay(function (array $ad, array $bs, int $weekday) use ($converter, &$mismatches, &$days) {
            $days++;
            if ($converter::toBs(...$ad) !== $bs) {
                $mismatches[] = ['ad->bs', $ad, $bs];
            }
            if (Calendar::calculateDayOfWeek(...$bs) !== $weekday) {
                $mismatches[] = ['weekday', $bs, $weekday];
            }
            if ($bs[0] >= Calendar::START_YEAR_BS && $bs[0] <= Calendar::END_YEAR_BS && $converter::toAd(...$bs) !== $ad) {
                $mismatches[] = ['bs->ad', $bs, $ad];
            }
            if (count($mismatches) > 20) {
                throw new RuntimeException('Too many mismatches: '.json_encode($mismatches));
            }
        });

        expect($mismatches)->toBe([])
            ->and($days)->toBe(73_780);
    });

    it('matches the previous month-walk converter on the first and last day of every month', function () use ($converter) {
        $mismatches = [];
        for ($year = Calendar::START_YEAR_BS; $year <= Calendar::END_YEAR_BS; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                foreach ([1, Calendar::getDaysInBSMonth($year, $month)] as $day) {
                    if ($converter::toAd($year, $month, $day) !== LegacyMonthWalkConverter::bsToAd($year, $month, $day)) {
                        $mismatches[] = ['bs', $year, $month, $day];
                    }
                }
            }
        }
        for ($year = Calendar::START_YEAR_AD; $year <= 2044; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                foreach ([1, Calendar::getDaysInADMonth($year, $month)] as $day) {
                    if ($converter::toBs($year, $month, $day) !== LegacyMonthWalkConverter::adToBs($year, $month, $day)) {
                        $mismatches[] = ['ad', $year, $month, $day];
                    }
                }
            }
        }

        expect($mismatches)->toBe([]);
    });

    it('round-trips every BS date through AD and back', function () use ($converter) {
        $failures = 0;
        for ($year = Calendar::START_YEAR_BS; $year <= Calendar::END_YEAR_BS; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $daysInMonth = Calendar::getDaysInBSMonth($year, $month);
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    if ($converter::toBs(...$converter::toAd($year, $month, $day)) !== [$year, $month, $day]) {
                        $failures++;
                    }
                }
            }
        }

        expect($failures)->toBe(0);
    });

    it('converts the first and last supported days', function () use ($converter) {
        expect($converter::toAd(1900, 1, 1))->toBe([1843, 4, 13])
            ->and($converter::toBs(1843, 4, 13))->toBe([1900, 1, 1])
            ->and($converter::toAd(2100, 12, 31))->toBe([2044, 4, 13])
            ->and($converter::toBs(2044, 4, 13))->toBe([2100, 12, 31])
            // The AD range is wider than the BS range: its ends map just outside BS 1900–2100.
            ->and($converter::toBs(1843, 1, 1))->toBe([1899, 9, 18])
            ->and($converter::toBs(2044, 12, 31))->toBe([2101, 9, 15]);
    });

    it('handles 32-day BS months and AD leap days', function () use ($converter) {
        expect(Calendar::getDaysInBSMonth(2081, 2))->toBe(32)
            ->and($converter::toBs(...$converter::toAd(2081, 2, 32)))->toBe([2081, 2, 32])
            ->and($converter::toAd(2081, 2, 32))->toBe([2024, 6, 14])
            ->and($converter::toBs(2024, 2, 29))->toBe([2080, 11, 17])
            ->and($converter::toBs(2000, 2, 29))->toBe([2056, 11, 17]);
    });

    it('still rejects out-of-range dates with the same errors', function () use ($converter) {
        expect(fn () => $converter::toAd(1899, 12, 1))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid BS year: 1899. Valid range is 1900 to 2100.')
            ->and(fn () => $converter::toAd(2101, 1, 1))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid BS year: 2101. Valid range is 1900 to 2100.')
            ->and(fn () => $converter::toAd(2082, 1, 32))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid day: 32 for month: 1 and year: 2082. Valid range is 1 to 31.')
            ->and(fn () => $converter::toBs(1842, 12, 31))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid AD year: 1842. Valid range is 1843 to 2044.')
            ->and(fn () => $converter::toBs(2045, 1, 1))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid AD year: 2045. Valid range is 1843 to 2044.')
            ->and(fn () => $converter::toBs(1900, 2, 29))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid day: 29 for month: 2 and year: 1900. Valid range is 1 to 28.')
            ->and(fn () => $converter::toBs(2025, 13, 1))
            ->toThrow(NepaliDateOutOfBoundsException::class, 'Invalid month: 13. Valid range is 1 to 12.');
    });

    it('keeps the day totals used by getTotalBSDays and getTotalADDays', function () {
        expect(Calendar::getTotalBSDays(1900, 1, 1))->toBe(1)
            ->and(Calendar::getTotalADDays(1844, 1, 1))->toBe(1)
            ->and(Calendar::getTotalADDays(1843, 1, 1))->toBe(-364)
            ->and(Calendar::getTotalADDays(1843, 12, 31))->toBe(0)
            ->and(Calendar::getTotalBSDays(2082, 7, 29))->toBe(66_692);
    });

    it('gives NepaliDate the correct weekday, including dates before 1 Baisakh 1900', function () {
        expect(NepaliDate::fromNotation('1843-01-01')->getWeekDay())->toBe(1) // Sunday
            ->and(NepaliDate::fromNotation('2025-11-15')->getWeekDay())->toBe(7); // Saturday
    });

    it('converts 10,000 dates each way quickly', function () use ($converter) {
        $converter::toBs(2025, 1, 1); // build the tables outside the timed loop
        $start = hrtime(true);
        for ($i = 0; $i < 10_000; $i++) {
            $converter::toBs(1950 + $i % 90, 1 + $i % 12, 1 + $i % 28);
            $converter::toAd(2000 + $i % 90, 1 + $i % 12, 1 + $i % 28);
        }
        $elapsedMs = (hrtime(true) - $start) / 1e6;

        // ~20 ms on a laptop; the old month walk took ~2,000 ms. Loose bound for slow CI.
        expect($elapsedMs)->toBeLessThan(250);
    });
});
