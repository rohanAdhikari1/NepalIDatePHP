<?php

declare(strict_types=1);

use RohanAdhikari\NepaliDate\Constants\Calendar;

it('detects leap years correctly', function () {
    expect(Calendar::isLeapYear(2000))->toBeTrue()
        ->and(Calendar::isLeapYear(1900))->toBeFalse()
        ->and(Calendar::isLeapYear(2024))->toBeTrue()
        ->and(Calendar::isLeapYear(2004))->toBeTrue()
        ->and(Calendar::isLeapYear(2023))->toBeFalse();
});

it('returns correct AD month days', function () {
    expect(Calendar::getDaysInADMonth(2023, 2))->toBe(28)
        ->and(Calendar::getDaysInADMonth(2024, 2))->toBe(29)
        ->and(Calendar::getDaysInADMonth(2024, 1))->toBe(31)
        ->and(Calendar::getDaysInADMonth(2024, 10))->toBe(31);
});

it('returns correct BS month days', function () {
    expect(Calendar::getDaysInBSMonth(2000, 1))->toBe(30)
        ->and(Calendar::getDaysInBSMonth(2000, 2))->toBe(32)
        ->and(Calendar::getDaysInBSMonth(2100, 12))->toBe(31)
        ->and(Calendar::getDaysInBSMonth(2061, 12))->toBe(31)
        ->and(Calendar::getDaysInBSMonth(2068, 10))->toBe(29)
        ->and(Calendar::getDaysInBSMonth(2082, 6))->toBe(31);
});

it('calculates total AD days correctly', function () {
    $prevDay = Calendar::getTotalADDays(2024, 2, 29);
    $nextDay = Calendar::getTotalADDays(2024, 3, 1);
    expect($nextDay - $prevDay)->toBe(1);

    $start = Calendar::getTotalADDays(2024, 1, 1);
    $end = Calendar::getTotalADDays(2024, 1, 10);
    expect($end - $start)->toBe(9);

    $sameDay1 = Calendar::getTotalADDays(2024, 6, 15);
    $sameDay2 = Calendar::getTotalADDays(2024, 6, 15);
    expect($sameDay2 - $sameDay1)->toBe(0);
});

it('calculates total BS days correctly', function () {
    $days1900 = Calendar::getTotalBSDays(1900, 1, 1);
    $days2000 = Calendar::getTotalBSDays(2000, 1, 1);
    $days2001 = Calendar::getTotalBSDays(2001, 1, 1);
    expect($days1900)->toBe(1)
        ->and($days2000)->toBe(36526)
        ->and($days2001)->toBe(36891);

    $prevDay = Calendar::getTotalBSDays(2005, 2, 31);
    $nextDay = Calendar::getTotalbSDays(2005, 3, 1);
    expect($nextDay - $prevDay)->toBe(1);

    $start = Calendar::getTotalBSDays(2010, 1, 1);
    $end = Calendar::getTotalBSDays(2010, 1, 10);
    expect($end - $start)->toBe(9);

    $sameDay1 = Calendar::getTotalBSDays(2082, 6, 30);
    $sameDay2 = Calendar::getTotalBSDays(2082, 6, 30);
    expect($sameDay2 - $sameDay1)->toBe(0);
});

it('calculates correct day of week for BS date', function () {
    $day = Calendar::calculateDayOfWeek(2082, 6, 30);
    $day2 = Calendar::calculateDayOfWeek(2061, 12, 15);
    $day3 = Calendar::calculateDayOfWeek(2068, 10, 7);
    expect($day)->toBe(5)
        ->and($day2)->toBe(2)
        ->and($day3)->toBe(7);
});
