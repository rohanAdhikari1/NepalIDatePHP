<?php

use RohanAdhikari\NepaliDate\NepaliDateInterface;
use RohanAdhikari\NepaliDate\Traits\useLocale;

describe('Locale Functions Test', function () {
    $class = new class {
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
        expect($class::getAvailableLocales())->toBe(NepaliDateInterface::ENGLISH, NepaliDateInterface::NEPALI);
    });

    it('can verify if a locale exists', function () use ($class) {
        expect($class::localeExists(NepaliDateInterface::ENGLISH))->toBe(true);
        expect($class::localeExists(NepaliDateInterface::NEPALI))->toBe(true);
        expect($class::localeExists('in'))->toBe(false);
        expect($class::localeExists('us'))->toBe(false);
    });

    // it('does locale customize work', function () use ($class) {
    //     $class::resetAllLocaleData();
    // });
});
