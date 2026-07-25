<?php

require __DIR__ . '/../vendor/autoload.php';

use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\Traits\DateConverter;

$converter = new class
{
    use DateConverter;
    public static function callBStoAD(int $y, int $m, int $d): array
    {
        return self::BStoAD($y, $m, $d);
    }

    public static function callADtoBS(int $y, int $m, int $d): array
    {
        return self::ADtoBS($y, $m, $d);
    }
};

$start = hrtime(true);
$checked = 0;
$mismatches = [];

for ($year = Calendar::START_YEAR_BS; $year <= Calendar::END_YEAR_BS; $year++) {
    for ($month = 1; $month <= 12; $month++) {
        $daysInMonth = Calendar::getDaysInBSMonth($year, $month);

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $checked++;
            $ad = $converter::callBStoAD($year, $month, $day);
            $roundTripped = $converter::callADtoBS(...$ad);

            if ($roundTripped !== [$year, $month, $day]) {
                $mismatches[] = [
                    'bs' => [$year, $month, $day],
                    'ad' => $ad,
                    'roundTripped' => $roundTripped,
                ];
            }
        }
    }
}

$elapsed = (hrtime(true) - $start) / 1_000_000_000;

printf("Checked %s dates in %.2fs (%.1f us/date pair)\n", number_format($checked), $elapsed, ($elapsed / $checked) * 1_000_000);

if ($mismatches === []) {
    echo "All dates round-tripped correctly.\n";
    exit(0);
}

printf("%d mismatches found:\n", count($mismatches));
foreach (array_slice($mismatches, 0, 20) as $mismatch) {
    printf(
        "  BS %s -> AD %s -> BS %s (expected %s)\n",
        implode('-', $mismatch['bs']),
        implode('-', $mismatch['ad']),
        implode('-', $mismatch['roundTripped']),
        implode('-', $mismatch['bs'])
    );
}
exit(1);
