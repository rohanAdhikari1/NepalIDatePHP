<?php

use RohanAdhikari\NepaliDate\NepaliNumbers;

describe(
    'NepaliNumbers Test',
    function () {
        it('converts English numbers to Nepali numbers', function () {
            expect(NepaliNumbers::convertToNepali(1234567890))->toBe('१२३४५६७८९०');
            expect(NepaliNumbers::convertToNepali('507'))->toBe('५०७');
        });

        it('converts Nepali numbers to English numbers', function () {
            expect(NepaliNumbers::convertToEnglish('१२३'))->toBe('123');
            expect(NepaliNumbers::convertToEnglish('९८७६'))->toBe('9876');
        });

        it('pads numbers to two digits', function () {
            expect(NepaliNumbers::getTwoDigitNumber(5))->toBe('05');
            expect(NepaliNumbers::getTwoDigitNumber(23))->toBe('23');
        });

        it('formats numbers in Nepali style', function () {
            expect(NepaliNumbers::nepaliNumberFormat('1234567'))->toBe('12,34,567');
            expect(NepaliNumbers::nepaliNumberFormat('1234.56'))->toBe('1,234.56');
        });

        it('returns Nepali currency with symbol and formatting', function () {
            expect(NepaliNumbers::getNepaliCurrency(1234567))->toBe('रू १२,३४,५६७');
            expect(NepaliNumbers::getNepaliCurrency(1234567, false))->toBe('१२,३४,५६७');
            expect(NepaliNumbers::getNepaliCurrency(1234567, true, true))->toBe('रू १२,३४,५६७ मात्र');
            expect(NepaliNumbers::getNepaliCurrency(1234567, true, true, format: false))->toBe('रू १२३४५६७ मात्र');
        });

        it('converts numbers to Nepali words', function () {
            expect(NepaliNumbers::getNepaliWord('123'))->toBe('एक सय तेइस रुपैंया');
            expect(NepaliNumbers::getNepaliWord('123.45'))->toBe('एक सय तेइस रुपैंया, पैंतालिस पैसा');
            expect(NepaliNumbers::getNepaliWord('5', false))->toBe('पाँच');
        });

        it('converts numbers according to locale', function () {
            $convert = NepaliNumbers::converter('en');
            expect($convert('123'))->toBe('One Hundred Twenty Three');
            $convert2 = NepaliNumbers::converter('np');
            expect($convert2('507'))->toBe('पाँच सय सात');
        });

        it('throws exception for numbers greater than supported', function () {
            $largeNumber = str_repeat('1', 21); // More than Shankh
            expect(fn () => NepaliNumbers::getNepaliWord($largeNumber, locale: 'en'))->toThrow(\InvalidArgumentException::class);
        });
    }
);
