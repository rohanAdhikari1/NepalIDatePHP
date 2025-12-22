<?php

require __DIR__ . '/../vendor/autoload.php';

use RohanAdhikari\NepaliDate\NepaliDate;

$start = microtime(true);
$nepaliDate = NepaliDate::fromAd(new DateTime());
$end = microtime(true);
$executionTimeMs = ($end - $start) * 1000;

echo "Execution time: {$executionTimeMs} milliseconds";
