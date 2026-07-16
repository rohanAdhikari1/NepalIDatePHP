<?php

use RohanAdhikari\NepaliDate\NepaliDateInterface;
use RohanAdhikari\NepaliDate\Traits\useLocale;

describe('Locale Functions Test', function () {
    $class = new class
    {
        use useLocale;

        public static function callGetIndexFromMonths(string $v): ?int
        {
            return self::getIndexFromMonths($v);
        }

        public static function callGetIndexFromShortMonths(string $v): ?int
        {
            return self::getIndexFromShortMonths($v);
        }

        public static function callGetIndexFromWeekDays(string $v): ?int
        {
            return self::getIndexFromWeekDays($v);
        }

        public static function callGetIndexFromShortWeekDays(string $v): ?int
        {
            return self::getIndexFromShortWeekDays($v);
        }
    };
    it('return correct locale', function () use ($class) {
        $class::defaultLocale(NepaliDateInterface::ENGLISH);
        $locale = $class->getLocale();
        expect($locale)->toBe(NepaliDateInterface::ENGLISH);
        $class::defaultLocale(NepaliDateInterface::NEPALI);
        $locale2 = $class->getLocale();
        expect($locale2)->toBe(NepaliDateInterface::NEPALI);
        $class->setLocale(NepaliDateInterface::ENGLISH);
        $locale3 = $class->getLocale();
        expect($locale3)->toBe(NepaliDateInterface::ENGLISH);
        expect($class::getAvailableLocales())->toBe([NepaliDateInterface::ENGLISH, NepaliDateInterface::NEPALI]);
    });

    it('can verify if a locale exists', function () use ($class) {
        expect($class::localeExists(NepaliDateInterface::ENGLISH))->toBe(true);
        expect($class::localeExists(NepaliDateInterface::NEPALI))->toBe(true);
        expect($class::localeExists('in'))->toBe(false);
        expect($class::localeExists('us'))->toBe(false);
    });

    it('does locale customize work', function () use ($class) {
        $class::resetAllLocaleData();
        $class::customizeLocale(NepaliDateInterface::ENGLISH, ['months' => [
            'Baisakh',
            'Jestha',
            'Ashar',
            'Shawan',
            'Bhadau',
            'Asoj',
            'Kartik',
            'Mangsir',
            'Push',
            'Magh',
            'Fagun',
            'Chait',
        ]]);
        $month = $class::getLocaleValueFor('months', 5, NepaliDateInterface::ENGLISH);
        expect($month)->toBe('Bhadau');
        $month2 = $class::getLocaleValueFor('months', 12, NepaliDateInterface::ENGLISH);
        expect($month2)->toBe('Chait');
    });

    it('return correct index from month after customization', function () use ($class) {
        expect($class::callGetIndexFromMonths('Chait'))->toBe(11);
        expect($class::callGetIndexFromMonths('Shrawan'))->toBe(null);
        expect($class::callGetIndexFromMonths('फाल्गुण'))->toBe(10);
        expect($class::callGetIndexFromMonths('श्रावण'))->toBe(3);
        expect($class::callGetIndexFromMonths('December'))->toBe(null);
    });

    it('return correct index from Short month', function () use ($class) {
        expect($class::callGetIndexFromShortMonths('Ash'))->toBe(2);
        expect($class::callGetIndexFromShortMonths('Pou'))->toBe(8);
        expect($class::callGetIndexFromShortMonths('पौ'))->toBe(8);
        expect($class::callGetIndexFromShortMonths('चै'))->toBe(11);
        expect($class::callGetIndexFromShortMonths('Dec'))->toBe(null);
    });

    it('return correct index from WeekDay', function () use ($class) {
        expect($class::callGetIndexFromWeekDays('Sunday'))->toBe(0);
        expect($class::callGetIndexFromWeekDays('Saturday'))->toBe(6);
        expect($class::callGetIndexFromWeekDays('आइतबार'))->toBe(0);
        expect($class::callGetIndexFromWeekDays('शनिबार'))->toBe(6);
    });

    it('return correct index from Short WeekDay', function () use ($class) {
        expect($class::callGetIndexFromShortWeekDays('Mon'))->toBe(1);
        expect($class::callGetIndexFromShortWeekDays('Fri'))->toBe(5);
        expect($class::callGetIndexFromShortWeekDays('सोम'))->toBe(1);
        expect($class::callGetIndexFromShortWeekDays('शुक्र'))->toBe(5);
    });

    it('locale reset all works?', function () use ($class) {
        $class::resetAllLocaleData();
        $month = $class::getLocaleValueFor('months', 5, NepaliDateInterface::ENGLISH);
        expect($month)->toBe('Bhadra');
        $month2 = $class::getLocaleValueFor('months', 12, NepaliDateInterface::ENGLISH);
        expect($month2)->toBe('Chaitra');
    });
});
