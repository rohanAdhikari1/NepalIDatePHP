<?php

use RohanAdhikari\NepaliDate\NepaliDateInterface;
use RohanAdhikari\NepaliDate\Traits\useLocale;

describe('Locale Functions Test', function () {
    $class = new class
    {
        use useLocale;
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
        $method = new ReflectionMethod($class, 'getIndexFromMonths');
        $method->setAccessible(true);
        expect($method->invoke($class, 'Chait'))->toBe(11);
        expect($method->invoke($class, 'Shrawan'))->toBe(null);
        expect($method->invoke($class, 'फाल्गुण'))->toBe(10);
        expect($method->invoke($class, 'श्रावण'))->toBe(3);
        expect($method->invoke($class, 'December'))->toBe(null);
    });

    it('return correct index from Short month', function () use ($class) {
        $method = new ReflectionMethod($class, 'getIndexFromShortMonths');
        $method->setAccessible(true);
        expect($method->invoke($class, 'Ash'))->toBe(2);
        expect($method->invoke($class, 'Pou'))->toBe(8);
        expect($method->invoke($class, 'पौ'))->toBe(8);
        expect($method->invoke($class, 'चै'))->toBe(11);
        expect($method->invoke($class, 'Dec'))->toBe(null);
    });

    it('return correct index from WeekDay', function () use ($class) {
        $method = new ReflectionMethod($class, 'getIndexFromWeekDays');
        $method->setAccessible(true);
        expect($method->invoke($class, 'Sunday'))->toBe(0);
        expect($method->invoke($class, 'Saturday'))->toBe(6);
        expect($method->invoke($class, 'आइतबार'))->toBe(0);
        expect($method->invoke($class, 'शनिबार'))->toBe(6);
    });

    it('return correct index from Short WeekDay', function () use ($class) {
        $method = new ReflectionMethod($class, 'getIndexFromShortWeekDays');
        $method->setAccessible(true);
        expect($method->invoke($class, 'Mon'))->toBe(1);
        expect($method->invoke($class, 'Fri'))->toBe(5);
        expect($method->invoke($class, 'सोम'))->toBe(1);
        expect($method->invoke($class, 'शुक्र'))->toBe(5);
    });

    it('locale reset all works?', function () use ($class) {
        $class::resetAllLocaleData();
        $month = $class::getLocaleValueFor('months', 5, NepaliDateInterface::ENGLISH);
        expect($month)->toBe('Bhadra');
        $month2 = $class::getLocaleValueFor('months', 12, NepaliDateInterface::ENGLISH);
        expect($month2)->toBe('Chaitra');
    });
});
