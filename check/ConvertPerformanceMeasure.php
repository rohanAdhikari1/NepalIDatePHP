<?php
require __DIR__ . '/../vendor/autoload.php';

use RohanAdhikari\NepaliDate\NepaliDate;

/**
 * @return array{seconds: float, memoryBytes: int}
 */
function benchmark(callable $fn, int $iterations): array
{
    $fn(0);

    gc_collect_cycles();
    $memoryBefore = memory_get_usage();
    $start = hrtime(true);

    for ($i = 0; $i < $iterations; $i++) {
        $fn($i);
    }

    $elapsedNs = hrtime(true) - $start;
    $memoryAfter = memory_get_peak_usage();

    return [
        'seconds' => $elapsedNs / 1_000_000_000,
        'memoryBytes' => max(0, $memoryAfter - $memoryBefore),
    ];
}

function formatRow(string $label, int $iterations, array $result): string
{
    $totalMs = $result['seconds'] * 1000;
    $perOpUs = ($result['seconds'] / $iterations) * 1_000_000;
    $memoryKb = $result['memoryBytes'] / 1024;

    return sprintf(
        "%-38s %10s ops  %12.3f ms total  %10.4f us/op  %10.1f KB peak\n",
        $label,
        number_format($iterations),
        $totalMs,
        $perOpUs,
        $memoryKb
    );
}

$iterations = isset($argv[1]) ? max(1, (int) $argv[1]) : 10_000;

$sampleAdDates = [];
for ($year = 1950; $year <= 2024; $year += 3) {
    $sampleAdDates[] = new DateTime("{$year}-06-15");
}

$sampleBsDates = array_map(
    static fn(DateTime $ad): NepaliDate => NepaliDate::fromAd($ad),
    $sampleAdDates
);

echo "NepaliDate conversion benchmark — {$iterations} iterations per case\n";
echo str_repeat('-', 100) . "\n";

echo formatRow(
    'AD -> BS  (NepaliDate::fromAd)',
    $iterations,
    benchmark(function (int $i) use ($sampleAdDates) {
        NepaliDate::fromAd($sampleAdDates[$i % count($sampleAdDates)]);
    }, $iterations)
);

echo formatRow(
    'BS -> AD  ($date->toAd())',
    $iterations,
    benchmark(function (int $i) use ($sampleBsDates) {
        $sampleBsDates[$i % count($sampleBsDates)]->toAd();
    }, $iterations)
);

echo formatRow(
    'Format    ($date->format())',
    $iterations,
    benchmark(function (int $i) use ($sampleBsDates) {
        $sampleBsDates[$i % count($sampleBsDates)]->format(NepaliDate::FORMAT_DATETIME_24_FULL);
    }, $iterations)
);

echo formatRow(
    'now() -> BS',
    $iterations,
    benchmark(static function (int $i) {
        NepaliDate::now();
    }, $iterations)
);

echo str_repeat('-', 100) . "\n";
echo "Bulk-record simulation ({$iterations} rows: AD in, formatted BS string out)\n";

$bulkResult = benchmark(function (int $i) use ($sampleAdDates) {
    $date = NepaliDate::fromAd($sampleAdDates[$i % count($sampleAdDates)]);
    $date->format(NepaliDate::FORMAT_DATE_YMD);
}, $iterations);

echo formatRow('Bulk convert + format', $iterations, $bulkResult);
echo sprintf("Estimated throughput: %s rows/sec\n", number_format($iterations / $bulkResult['seconds']));
