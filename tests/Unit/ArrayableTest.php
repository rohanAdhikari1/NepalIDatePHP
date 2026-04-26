<?php

use RohanAdhikari\NepaliDate\NepaliDate;

describe('Locale Functions Test', function () {
    it('supports array round-trip conversion', function () {
        $original = new NepaliDate(
            year: 2026,
            month: 4,
            day: 26,
            hour: 12,
            minute: 45,
            second: 50,
            timezone: 'UTC'
        );

        $array = $original->toArray();
        $restored = NepaliDate::fromArray($array);

        expect($restored->toArray())
            ->toBe($array);
    });
});
