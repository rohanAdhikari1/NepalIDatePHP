<?php

namespace RohanAdhikari\NepaliDate;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

/**
 * @property int $year
 * @property int $month
 * @property int $day
 * @property int $hour
 * @property int $minute
 * @property int $second
 * @property string $locale
 * @property DateTimeZone $timezone
 * @property-read int $twoDigitMonth
 * @property-read int $weekDay
 * @property-read string $shortYear
 * @property-read int $millennium
 * @property-read int $century
 * @property-read int $decade
 * @property-read int $quarter
 * @property-read string $twoDigitDay
 * @property-read int $shortHour
 * @property-read string $twoDigitShortHour
 * @property-read string $twoDigitHour
 * @property-read string $twoDigitMinute
 * @property-read string $twoDigitSecond
 * @property-read string $maridian
 * @property-read string $timezoneName
 * @property-read string $tzName
 * @property-read int $daysInMonth
 * @property-read string $localeMillennium
 * @property-read string $localeCentury
 * @property-read string $localeDecade
 * @property-read string $localeYear
 * @property-read string $localeShortYear
 * @property-read string $localeQuarter
 * @property-read string $localeMonth
 * @property-read string $localeTwoDigitMonth
 * @property-read string $localeMonthName
 * @property-read string $localeShortMonthName
 * @property-read string $localeWeekDay
 * @property-read string $localeWeekDayName
 * @property-read string $localeShortWeekDayName
 * @property-read string $localeDay
 * @property-read string $localeTwoDigitDay
 * @property-read string $localeHour
 * @property-read string $localeShortHour
 * @property-read string $localeTwoDigitShortHour
 * @property-read string $localeTwoDigitHour
 * @property-read string $localeMinute
 * @property-read string $localeTwoDigitMinute
 * @property-read string $localeSecond
 * @property-read string $localeTwoDigitSecond
 * @property-read string $localeMaridian
 *
 * @method static $this setYear(int $year)
 * @method static $this setMonth(int $month)
 * @method static $this setDay(int $day)
 * @method static $this setHour(int $hour)
 * @method static $this setMinute(int $minute)
 * @method static $this setSecond(int $second)
 * @method static $this setTimezone(DateTimeZone $timezone)
 * @method static $this setTimeZone(DateTimeZone $timezone)
 * @method static $this setTZ(DateTimeZone $timezone)
 * @method static $this setTZone(DateTimeZone $timezone)
 * @method static $this addYear(int $value)
 * @method static $this addYears(int $value)
 * @method static $this addMonth(int $value)
 * @method static $this addMonths(int $value)
 * @method static $this addDay(int $value)
 * @method static $this addDays(int $value)
 * @method static $this addHour(int $value)
 * @method static $this addHours(int $value)
 * @method static $this addMinute(int $value)
 * @method static $this addMinutes(int $value)
 * @method static $this addSecond(int $value)
 * @method static $this addSeconds(int $value)
 * @method static $this subYear(int $value)
 * @method static $this subYears(int $value)
 * @method static $this subMonth(int $value)
 * @method static $this subMonths(int $value)
 * @method static $this subDay(int $value)
 * @method static $this subDays(int $value)
 * @method static $this subHour(int $value)
 * @method static $this subHours(int $value)
 * @method static $this subMinute(int $value)
 * @method static $this subMinutes(int $value)
 * @method static $this subSecond(int $value)
 * @method static $this subSeconds(int $value)
 */
interface NepaliDateInterface
{
    /**
     * The day constants.
     */
    public const SUNDAY = 1;

    public const MONDAY = 2;

    public const TUESDAY = 3;

    public const WEDNESDAY = 4;

    public const THURSDAY = 5;

    public const FRIDAY = 6;

    public const SATURDAY = 7;

    /**
     * The Month constants.
     */
    public const BAISAKH = 1;

    public const JESTHA = 2;

    public const ASHAR = 3;

    public const SHRAWAN = 4;

    public const BHADRA = 5;

    public const ASOJ = 6;

    public const KARTHIK = 7;

    public const MANGHSIR = 8;

    public const PAUSH = 9;

    public const MAGH = 10;

    public const FALGUN = 11;

    public const CHAITRA = 12;

    /**
     * The Default Locale constants.
     */
    public const ENGLISH = 'en';

    public const NEPALI = 'np';

    /**
     * Common formats
     */
    // Basic Date Formats
    public const FORMAT_DATE_YMD = 'Y-m-d';           // 2082-06-25

    public const FORMAT_DATE_DMY = 'd-m-Y';           // 25-06-2082

    public const FORMAT_DATE_MDY = 'm-d-Y';           // 06-25-2082

    public const FORMAT_DATE_SLASH_YMD = 'Y/m/d';           // 2082/06/25

    public const FORMAT_DATE_SLASH_DMY = 'd/m/Y';           // 25/06/2082

    // Time Formats
    public const FORMAT_TIME_24 = 'H:i';             // 23:21

    public const FORMAT_TIME_24_WITH_SEC = 'H:i:s';           // 23:21:27

    public const FORMAT_TIME_12 = 'h:i A';           // 11:21 PM

    public const FORMAT_TIME_12_WITH_SEC = 'h:i:s A';         // 11:21:27 PM

    // Full DateTime Formats
    public const FORMAT_DATETIME_24 = 'Y-m-d H:i';       // 2082-06-25 23:21

    public const FORMAT_DATETIME_24_FULL = 'Y-m-d H:i:s';     // 2082-06-25 23:21:27

    public const FORMAT_DATETIME_12_FULL = 'Y-m-d h:i:s A';   // 2082-06-25 11:21:27 PM

    // Readable Formats
    public const FORMAT_READABLE_DATE = 'l, F j, Y';       // Saturday, Ashwin 25, 2082

    public const FORMAT_READABLE_DATETIME = 'l, F j, Y g:i A'; // Saturday, Ashwin 25, 2082 11:45 PM

    public const FORMAT_READABLE_DATETIME2 = 'D, d M Y H:i:s';  // Wed, 29 Asw 2082 12:50:05

    // ISO and RFC Formats
    public const FORMAT_ISO_8601 = 'c';

    public const FORMAT_RFC_2822 = 'r';

    public const FORMAT_UNIX_TIMESTAMP = 'U';

    // File Safe Format
    public const FORMAT_FILENAME_SAFE = 'Y-m-d_H-i-s';     // 2082-06-25_23-47-44

    public function __construct(
        int $year,
        int $month,
        int $day,
        int $hour = 0,
        int $minute = 0,
        int $second = 0,
        string $timezone = 'Asia/Kathmandu'
    );

    public static function fromInstance(NepaliDateInterface $instance): static;

    public static function fromAd(DateTime $datetime): static;

    public static function fromNotation(string $notation, string $timezone = 'Asia/Kathmandu'): static;

    public static function now(string $timezone = 'Asia/Kathmandu'): static;

    public static function fromTimestamp(int $timestamp, string $timezone = 'Asia/Kathmandu'): static;

    public function __toString();

    public function toDateString(): string;

    public function toAd(): DateTimeInterface;

    public function getTimestamp(): int;

    public function nowWithSameTz(): NepaliDateInterface;

    public function format(string $format): string;

    // parse
    public static function addDefaultParserFormats(array $formats): void;

    public static function addDefaultParserFormat(string $format): void;

    public static function resetDefaultParserFormats(): void;

    public static function parse(string $dateString): static;

    public static function createFromFormat(string $format, string $dateString);

    // DateGetters
    public function getMillennium(): int;

    public function getCentury(): int;

    public function getDecade(): int;

    public function getYear(): int;

    public function getShortYear(): string;

    public function getMonth(): int;

    public function getTwoDigitMonth(): string;

    public function getQuarter(): int;

    public function getDay(): int;

    public function getTwoDigitDay(): string;

    public function getWeekDay(): int;

    public function getHour(): int;

    public function getTwoDigitHour(): string;

    public function getShortHour(): int;

    public function getTwoDigitShortHour(): string;

    public function getMinute(): int;

    public function getTwoDigitMinute(): string;

    public function getSecond(): int;

    public function getTwoDigitSecond(): string;

    public function getTimezone(): DateTimeZone;

    public function getTimezoneName(): string;

    public function getTZName(): string;

    public function getMaridian(): string;

    public function getLocaleMillennium(): string;

    public function getLocaleCentury(): string;

    public function getLocaleDecade(): string;

    public function getLocaleYear(): string;

    public function getLocaleShortYear(): string;

    public function getLocaleQuarter(): string;

    public function getLocaleMonth(): string;

    public function getLocaleTwoDigitMonth(): string;

    public function getLocaleMonthName(): string;

    public function getLocaleShortMonthName(): string;

    public function getLocaleWeekDay(): string;

    public function getLocaleWeekDayName(): string;

    public function getLocaleShortWeekDayName(): string;

    public function getLocaleDay(): string;

    public function getLocaleTwoDigitDay(): string;

    public function getLocaleHour(): string;

    public function getLocaleShortHour(): string;

    public function getLocaleTwoDigitShortHour(): string;

    public function getLocaleTwoDigitHour(): string;

    public function getLocaleMinute(): string;

    public function getLocaleTwoDigitMinute(): string;

    public function getLocaleSecond(): string;

    public function getLocaleTwoDigitSecond(): string;

    public function getLocaleMaridian(): string;

    public function getDaysInMonth(): int;

    // mutability
    public function isImmutable(): bool;

    public function toImmutable(): NepaliDateImmutable;

    public function toMutable(): NepaliDate;

    public function cast(): NepaliDateInterface;

    public function setUnit(string|NepaliUnit $unit, int $value): static;

    public function setTime(int $hour, int $minute, int $second): static;

    public function setDate(int $year, int $month, int $day): static;

    public function modifyUnit(string|NepaliUnit $unit, int $amount): static;

    public function shiftToNearWeek(int|NepaliWeekDay $weekday, bool $up = true): static;

    public function shiftTimezone(DateTimeZone|string $timezone): static;

    // Boundries
    public function startOfDay(): static;

    public function endOfDay(): static;

    public function startOfMonth(): static;

    public function endOfMonth(): static;

    public function startOfQuarter(): static;

    public function endOfQuarter(): static;

    public function startOfYear(): static;

    public function endOfYear(): static;

    public function startOfDecade(): static;

    public function endOfDecade(): static;

    public function startOfCentury(): static;

    public function endOfCentury(): static;

    public function startOfMillennium(): static;

    public function endOfMillennium(): static;

    public function startOfWeek(NepaliWeekDay|int|null $weekStartsAt = null): static;

    public function endOfWeek(NepaliWeekDay|int|null $weekEndsAt = null): static;

    public function startOfHour(): static;

    public function endOfHour(): static;

    public function startOfMinute(): static;

    public function endOfMinute(): static;

    public function startOf(NepaliUnit|string $unit, mixed ...$params): static;

    public function endOf(NepaliUnit|string $unit, mixed ...$params): static;

    // /comparision
    public function eq(NepaliDateInterface|string $date): bool;

    public function equalTo(NepaliDateInterface|string $date): bool;

    public function ne(NepaliDateInterface|string $date): bool;

    public function notEqualTo(NepaliDateInterface|string $date): bool;

    public function gt(NepaliDateInterface|string $date): bool;

    public function greaterThan(NepaliDateInterface|string $date): bool;

    public function isAfter(NepaliDateInterface|string $date): bool;

    public function gte(NepaliDateInterface|string $date): bool;

    public function greaterThanOrEqualTo(NepaliDateInterface|string $date): bool;

    public function lt(NepaliDateInterface|string $date): bool;

    public function lessThan(NepaliDateInterface|string $date): bool;

    public function isBefore(NepaliDateInterface|string $date): bool;

    public function lte(NepaliDateInterface|string $date): bool;

    public function lessThanOrEqualTo(NepaliDateInterface|string $date): bool;

    public function between(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2, bool $equal = true): bool;

    public function betweenIncluded(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2): bool;

    public function betweenExcluded(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2): bool;

    public function isBetween(NepaliDateInterface|string $date1, NepaliDateInterface|string $date2, bool $equal = true): bool;

    public function isWeekday(): bool;

    public function isWeekend(): bool;

    public function isYesterday(): bool;

    public function isToday(): bool;

    public function isTomorrow(): bool;

    public function isFuture(): bool;

    public function isPast(): bool;

    public function isNowOrFuture(): bool;

    public function isNowOrPast(): bool;

    // locale
    public function getLocale(): string;

    public static function defaultLocale(string $locale): void;

    public static function getGlobalDefaultLocale(): string;

    public function setLocale(string $locale): static;

    public static function localeExists(string $locale): bool;

    public static function getAvailableLocales(): array;

    public static function getLocaleDataFor(string $locale): array;

    public static function getLocalePartFor(string $part, string $locale): array;

    public static function getLocaleValueFor(string $part, int $index, string $locale): string;

    public function getLocaleData(?string $locale = null): array;

    public function getLocalePart(string $part, ?string $locale = null): array;

    public function getLocaleValue(string $part, int $index, ?string $locale = null): string;

    public static function getNumberConverter(string $locale): ?callable;

    public function convertNumberToLocale(int|string $number, ?string $locale = null): string;

    public static function customizeLocale(string $locale, array $data): void;

    public static function customizeLocaleMonths(string $locale, array $months): void;

    public static function customizeLocaleShortMonths(string $locale, array $months): void;

    public static function customizeLocaleWeekDays(string $locale, array $weekDays): void;

    public static function customizeLocaleShortWeekDays(string $locale, array $weekDays): void;

    public function resetLocale(): static;

    public static function resetAllLocaleData(): void;

    public function getLocaleMonths(): array;

    // overflow bounds
    public static function overflowGlobal(bool $enable = true): void;

    public static function overflowGlobalBound(string $type, bool $enable = true): void;

    public static function setStrictMode(bool $enable): void;

    public function overflowLocal(bool $enable = true): static;

    public function overflowBound(string $type, bool $enable = true): static;

    public static function isGlobalBoundActive(string $type): bool;

    public function isLocalBoundActive(string $type): ?bool;

    public function isOverflowActive(): bool;

    public function isBoundActive(string $type): bool;

    public static function resetOverflowSettings(): void;

    public function resetOverflow(): static;
}
