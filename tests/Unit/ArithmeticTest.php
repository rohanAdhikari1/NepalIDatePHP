<?php

use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

describe('unit arithmetic - months', function () {
    it('add month with overflow (mutable)', function () {
        $date = new NepaliDate(2082, 7, 30);
        $res = $date->addMonth();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(9);
        expect($res->getDay())->toBe(1);
    });

    it('add month no overflow (mutable)', function () {
        $date = new NepaliDate(2082, 7, 30);
        $res = $date->addMonthNoOverflow();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(8);
        expect($res->getDay())->toBe(29);
    });

    it('sub month (mutable)', function () {
        $date = new NepaliDate(2082, 9, 1);
        $res = $date->subMonth();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(8);
        expect($res->getDay())->toBe(1);
    });

    it('add month with overflow (immutable)', function () {
        $date = new NepaliDateImmutable(2082, 7, 30);
        $res = $date->addMonth();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(9);
        expect($res->getDay())->toBe(1);
        // original remains unchanged
        expect($date->getMonth())->toBe(7);
    });

    it('add month no overflow (immutable)', function () {
        $date = new NepaliDateImmutable(2082, 7, 30);
        $res = $date->addMonthNoOverflow();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(8);
        expect($res->getDay())->toBe(29);
        expect($date->getMonth())->toBe(7);
    });
});

describe('unit arithmetic - days', function () {
    it('add day at end of month (mutable)', function () {
        $date = new NepaliDate(2082, 1, 31);
        $res = $date->addDay();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(2);
        expect($res->getDay())->toBe(1);
    });

    it('sub day at start of month (mutable)', function () {
        $date = new NepaliDate(2082, 2, 1);
        $res = $date->subDay();

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(1);
        expect($res->getDay())->toBe(31);
    });

    it('sub day across year boundary (mutable)', function () {
        $date = new NepaliDate(2082, 1, 1);
        $res = $date->subDay();

        expect($res->getYear())->toBe(2081);
        expect($res->getMonth())->toBe(12);
        expect($res->getDay())->toBe(31);
    });

    it('add day across year boundary (immutable)', function () {
        $date = new NepaliDateImmutable(2082, 12, 30);
        $res = $date->addDay();

        expect($res->getYear())->toBe(2083);
        expect($res->getMonth())->toBe(1);
        expect($res->getDay())->toBe(1);
        expect($date->getDay())->toBe(30);
    });
});

describe('unit arithmetic - multi-day', function () {
    it('add 45 days (mutable)', function () {
        $date = new NepaliDate(2082, 6, 1);
        $res = $date->addDays(45);

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(7);
        expect($res->getDay())->toBe(15);
    });

    it('sub 45 days (mutable)', function () {
        $date = new NepaliDate(2082, 7, 15);
        $res = $date->subDays(45);

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(6);
        expect($res->getDay())->toBe(1);
    });

    it('add 60 days crossing year boundary (mutable)', function () {
        $date = new NepaliDate(2082, 11, 15);
        $res = $date->addDays(60);

        expect($res->getYear())->toBe(2083);
        expect($res->getMonth())->toBe(1);
        expect($res->getDay())->toBe(15);
    });

    it('add 45 days (immutable) preserves original', function () {
        $date = new NepaliDateImmutable(2082, 6, 1);
        $res = $date->addDays(45);

        expect($res->getYear())->toBe(2082);
        expect($res->getMonth())->toBe(7);
        expect($res->getDay())->toBe(15);
        expect($date->getMonth())->toBe(6);
    });
});
