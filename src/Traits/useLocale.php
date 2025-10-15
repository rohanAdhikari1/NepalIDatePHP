<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use RohanAdhikari\NepaliDate\Exceptions\InvalidNepaliDateLocale;
use RohanAdhikari\NepaliDate\NepaliDateInterface;

trait useLocale
{
    private static array $defaultLocales = [
        'en' => [
            'months' => [
                'Baisakh',
                'Jestha',
                'Ashadh',
                'Shrawan',
                'Bhadra',
                'Ashwin',
                'Kartik',
                'Mansir',
                'Poush',
                'Magh',
                'Falgun',
                'Chaitra',
            ],
            'shortMonths' => [
                'Bai',
                'Jes',
                'Ash',
                'Shr',
                'Bha',
                'Asw',
                'Kar',
                'Man',
                'Pou',
                'Mag',
                'Fal',
                'Cha',
            ],
            'weekdays' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            'shortWeekdays' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        ],
        'np' => [
            'months' => [
                'बैशाख',
                'ज्येष्ठ',
                'आषाढ',
                'श्रावण',
                'भाद्र',
                'आश्विन',
                'कार्तिक',
                'मंसिर',
                'पौष',
                'माघ',
                'फाल्गुण',
                'चैत्र',
            ],
            'shortMonths' => [
                'बै',
                'जे',
                'अ',
                'श्रा',
                'भा',
                'आ',
                'का',
                'मं',
                'पौ',
                'मा',
                'फा',
                'चै',
            ],
            'weekdays' => [
                'आइतबार',
                'सोमबार',
                'मङ्गलबार',
                'बुधबार',
                'बिहिबार',
                'शुक्रबार',
                'शनिबार',
            ],
            'shortWeekdays' => [
                'आइत',
                'सोम',
                'मंगल',
                'बुध',
                'बिहि',
                'शुक्र',
                'शनि',
            ],
        ],
    ];

    private static array $overrides = [];

    private static string $globalDefaultLocale = 'en';

    private ?string $locale = null;

    private static array $numberConverters = [
        'en' => null,
        'np' => [\RohanAdhikari\NepaliDate\NepaliNumbers::class, 'convertToNepali'],
    ];

    public function getLocale(): string
    {
        return $this->locale ?? self::$globalDefaultLocale;
    }

    public static function defaultLocale(string $locale): void
    {
        if (! self::localeExists($locale)) {
            throw new InvalidNepaliDateLocale("Locale '{$locale}' does not exist.");
        }
        self::$globalDefaultLocale = $locale;
    }

    public static function getGlobalDefaultLocale(): string
    {
        return self::$globalDefaultLocale;
    }

    public function setLocale(string $locale): static
    {
        if (! self::localeExists($locale)) {
            throw new InvalidNepaliDateLocale("Locale '{$locale}' does not exist.");
        }
        $this->locale = $locale;

        return $this;
    }

    public static function localeExists(string $locale): bool
    {
        return isset(self::$defaultLocales[$locale]);
    }

    public static function getAvailableLocales(): array
    {
        return array_keys(self::$defaultLocales);
    }

    public static function getLocaleDataFor(string $locale): array
    {
        if (! self::localeExists($locale)) {
            throw new InvalidNepaliDateLocale("Locale '{$locale}' does not exist.");
        }
        $default = self::$defaultLocales[$locale];
        $override = self::$overrides[$locale] ?? [];

        return array_merge($default, $override);
    }

    public static function getLocalePartFor(string $part, string $locale): array
    {
        $data = self::getLocaleDataFor($locale);

        if (! isset($data[$part])) {
            throw new InvalidNepaliDateLocale("Locale part '{$part}' does not exist in '{$locale}'.");
        }

        return $data[$part];
    }

    public static function getLocaleValueFor(string $part, int $index, string $locale): string
    {
        $partData = self::getLocalePartFor($part, $locale);

        if (! isset($partData[$index - 1])) {
            throw new InvalidNepaliDateLocale("Index {$index} does not exist in part '{$part}' of locale '{$locale}'.");
        }

        return $partData[$index - 1];
    }

    public function getLocaleData(?string $locale = null): array
    {
        $locale = $locale ?? $this->getLocale();
        if (! self::localeExists($locale)) {
            throw new InvalidNepaliDateLocale("Locale '{$locale}' does not exist.");
        }
        $default = self::$defaultLocales[$locale];
        $override = self::$overrides[$locale] ?? [];

        return array_merge($default, $override);
    }

    public function getLocalePart(string $part, ?string $locale = null): array
    {
        $data = $this->getLocaleData($locale);

        if (! isset($data[$part])) {
            throw new InvalidNepaliDateLocale("Locale part '{$part}' does not exist in '{$locale}'.");
        }

        return $data[$part];
    }

    public function getLocaleValue(string $part, int $index, ?string $locale = null): string
    {
        $partData = $this->getLocalePart($part, $locale);
        if (! isset($partData[$index - 1])) {
            throw new InvalidNepaliDateLocale("Index {$index} does not exist in part '{$part}' of locale '{$locale}'.");
        }

        return $partData[$index - 1];
    }

    protected static function getIndexFromLocaleValue(string $part, string $value, ?string $locale = null): ?int
    {
        $partData = static::getLocalePartFor($part, $locale);
        $index = array_search($value, $partData, true);

        return $index !== false ? $index : null;
    }

    public static function getNumberConverter(string $locale): ?callable
    {
        return self::$numberConverters[$locale] ?? null;
    }

    public function convertNumberToLocale(int|string $number, ?string $locale = null): string
    {
        $locale = $locale ?? $this->getLocale();
        $converter = self::getNumberConverter($locale);
        if ($converter === null) {
            return (string) $number;
        }

        return $converter($number);
    }

    public static function customizeocale(string $locale, array $data): void
    {
        if (! self::localeExists($locale)) {
            throw new InvalidNepaliDateLocale("Locale '{$locale}' does not exist. Cannot customize.");
        }

        foreach ($data as $part => $values) {
            if (! isset(self::$defaultLocales[$locale][$part])) {
                throw new InvalidNepaliDateLocale("Cannot customize unknown part '{$part}' in locale '{$locale}'.");
            }

            if (($part === 'months' || $part === 'shortMonths') && count($values) !== 12) {
                throw new InvalidNepaliDateLocale("Months must have exactly 12 items in locale '{$locale}'.");
            }
            if (($part === 'weekdays' || $part === 'shortWeekdays') && count($values) !== 7) {
                throw new InvalidNepaliDateLocale("Weekdays must have exactly 7 items in locale '{$locale}'.");
            }

            self::$overrides[$locale][$part] = $values;
        }
    }

    public function resetLocale(): static
    {
        $this->locale = null;

        return $this;
    }

    public static function resetAllLocaleData(): void
    {
        self::$overrides = [];
        self::$globalDefaultLocale = 'en';
    }

    public function getLocaleMonths(): array
    {
        return $this->getLocalePart('months');
    }

    protected function getMonthFromLocale(int $monthIndex): string
    {
        return $this->getLocaleValue('months', $monthIndex);
    }

    protected function getShortMonthFromLocale(int $monthIndex): string
    {
        return $this->getLocaleValue('shortMonths', $monthIndex);
    }

    protected function getWeekDayFromLocale(int $weekDayIndex): string
    {
        return $this->getLocaleValue('weekdays', $weekDayIndex);
    }

    protected function getShortWeekDayFromLocale(int $weekDayIndex): string
    {
        return $this->getLocaleValue('shortWeekdays', $weekDayIndex);
    }

    // retrieve index
    protected static function getIndexFromMonths(string $month): ?int
    {
        return static::getIndexFromLocaleValue('months', $month, NepaliDateInterface::ENGLISH) ??
            static::getIndexFromLocaleValue('months', $month, NepaliDateInterface::NEPALI);
    }

    protected static function getIndexFromShortMonths(string $month): ?int
    {
        return static::getIndexFromLocaleValue('shortMonths', $month, NepaliDateInterface::ENGLISH) ??
            static::getIndexFromLocaleValue('shortMonths', $month, NepaliDateInterface::NEPALI);
    }

    protected static function getIndexFromWeekDays(string $month): ?int
    {
        return static::getIndexFromLocaleValue('weekdays', $month, NepaliDateInterface::ENGLISH) ??
            static::getIndexFromLocaleValue('weekdays', $month, NepaliDateInterface::NEPALI);
    }

    protected static function getIndexFromShortWeekDays(string $month): ?int
    {
        return static::getIndexFromLocaleValue('shortWeekdays', $month, NepaliDateInterface::ENGLISH) ??
            static::getIndexFromLocaleValue('shortWeekdays', $month, NepaliDateInterface::NEPALI);
    }
}
