<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use DateTimeZone;
use Exception;
use RohanAdhikari\NepaliDate\Exceptions\NepaliDateFormatException;
use RohanAdhikari\NepaliDate\NepaliDateInterface;

trait haveDateParse
{
    /** @var string[] Default formats for parsing */
    protected static $defaultFormats = [
        'Y-m-d H:i:s',
        'Y-m-d h:i:s A',
        'h:i A',
        'h:i:s A',
        'H:i',
        'H:i:s',
        'U',
        'c',
        'r',
        'D, d M Y H:i:s',
        'l, F j, Y g:i A',
    ];

    /** @var array<string,string> */
    protected static $userFormats = [];

    /** @var array<string,string> */
    protected static array $regexCache = [];

    public static function addDefaultParserFormats(array $formats): void
    {
        foreach ($formats as $format) {
            static::addDefaultParserFormat($format);
        }
    }

    public static function addDefaultParserFormat(string $format): void
    {
        static::$userFormats[$format] = static::createRegexFromFormat($format);
    }

    public static function resetDefaultParserFormats(): void
    {
        static::$userFormats = [];
    }

    public static function parse(string $dateString): static
    {
        foreach (static::$userFormats as $regex) {
            if ($date = static::parseFromRegex($regex, $dateString)) {
                return $date;
            }
        }
        foreach (static::$defaultFormats as $format) {
            $regex = self::getRegexForFormat($format);
            if ($date = static::parseFromRegex($regex, $dateString)) {
                return $date;
            }
        }
        throw new NepaliDateFormatException('Unable to parse date: DateString is not compatible with Defaultformats. Please try parsing date using createFromFormat');
    }

    public static function createFromFormat(string $format, string $dateString)
    {
        $regex = self::getRegexForFormat($format);

        // return $regex;
        return static::parseFromRegex($regex, $dateString) ?? throw new NepaliDateFormatException('Unable to parse date: DateString is not compatible with format.');
    }

    protected static function getRegexForFormat(string $format): string
    {
        return self::$regexCache[$format] ??= self::createRegexFromFormat($format);
    }

    protected static function createRegexFromFormat(string $format): string
    {
        $monthsFull = array_merge(
            static::getLocalePartFor('months', NepaliDateInterface::ENGLISH),
            static::getLocalePartFor('months', NepaliDateInterface::NEPALI),
        );
        $monthsShort = array_merge(
            static::getLocalePartFor('shortMonths', NepaliDateInterface::ENGLISH),
            static::getLocalePartFor('shortMonths', NepaliDateInterface::NEPALI),
        );
        $daysFull = array_merge(
            static::getLocalePartFor('weekdays', NepaliDateInterface::ENGLISH),
            static::getLocalePartFor('weekdays', NepaliDateInterface::NEPALI),
        );
        $daysShort = array_merge(
            static::getLocalePartFor('shortWeekdays', NepaliDateInterface::ENGLISH),
            static::getLocalePartFor('shortWeekdays', NepaliDateInterface::NEPALI),
        );

        // Convert arrays to regex patterns
        $monthsFullPattern = '(?:'.implode('|', array_map('preg_quote', $monthsFull)).')';
        $monthsShortPattern = '(?:'.implode('|', array_map('preg_quote', $monthsShort)).')';
        $daysFullPattern = '(?:'.implode('|', array_map('preg_quote', $daysFull)).')';
        $daysShortPattern = '(?:'.implode('|', array_map('preg_quote', $daysShort)).')';
        $replacements = [
            // Year
            'Y' => '(?P<year>\d{4})',
            'y' => '(?P<year_short>\d{2})',

            // Month
            'm' => '(?P<month>0[1-9]|1[0-2])',
            'n' => '(?P<month>[1-9]|1[0-2])',
            'M' => "(?P<month_short>$monthsShortPattern)",
            'F' => "(?P<month_full>$monthsFullPattern)",

            // Day
            'd' => '(?P<day>0[1-9]|[12][0-9]|3[0-2])',
            'j' => '(?P<day>[1-9]|[12][0-9]|3[0-2])',

            // Week Day
            'D' => "(?P<weekday_short>$daysShortPattern)",
            'l' => "(?P<weekday_full>$daysFullPattern)",
            'w' => '(?P<weekday_num>[0-6])',

            // Time - 24-hour
            'H' => '(?P<hour24>[01][0-9]|2[0-3])?',
            'G' => '(?P<hour24>[0-9]|1[0-9]|2[0-3])',

            // Time - 12-hour
            'h' => '(?P<hour12>0[1-9]|1[0-2])',
            'g' => '(?P<hour12>[1-9]|1[0-2])',
            'a' => '(?P<ampm>am|pm)',
            'A' => '(?P<ampm>AM|PM)',

            // Minutes and seconds
            'i' => '(?P<minute>[0-5][0-9])',
            's' => '(?P<second>[0-5][0-9])',

            // Timezone
            'e' => '(?P<timezone>[A-Za-z_\/]+)',
            'O' => '(?P<timezone_offset>[+-]\d{4})',
            'P' => '(?P<timezone_offset_colon>[+-]\d{2}:\d{2})',
            'Z' => '(?P<timezone_seconds>-?\d+)',

            // Formats
            'c' => '(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2})T(?P<hour24>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})(?P<timezone_offset_colon>[+-]\d{2}:\d{2})',
            'r' => "(?P<weekday_short>$daysShortPattern), (?P<day>\d{2}) (?P<month_short>$monthsShortPattern) (?P<year>\d{4}) (?P<hour24>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2}) (?P<timezone_offset>[+-]\d{4})",
            'U' => '(?P<timestamp>\d+)',
        ];
        $regex = strtr($format, $replacements);

        return '/^'.$regex.'$/iu';
    }

    protected static function parseFromRegex(string $regex, string $date): ?static
    {
        $filterdate = $date;
        if (! preg_match($regex, $filterdate, $matches)) {
            return null;
        }
        $dateMap = array_filter(
            $matches,
            fn ($key) => ! is_int($key),
            ARRAY_FILTER_USE_KEY
        );
        if (empty($dateMap)) {
            throw new NepaliDateFormatException('Unable to parse date: no recognizable date components found.');
        }
        $timezone = static::getTimezoneFromMatches($dateMap);
        if (isset($dateMap['timestamp'])) {
            return static::fromTimestamp((int) $dateMap['timestamp'], $timezone);
        }
        $now = static::now();
        $year = $month = $day = null;
        $hour = $minute = $second = 0;

        // --- YEAR ---
        if (isset($dateMap['year_short'])) {
            $year = (int) substr((string) $now->year, 0, 2).$dateMap['year_short'];
        }
        if (isset($dateMap['year'])) {
            $year = (int) $dateMap['year'];
        }

        // --- MONTH ---
        if (isset($dateMap['month_short'])) {
            $monthIndex = static::getIndexFromShortMonths($dateMap['month_short']);
            if ($monthIndex !== null) {
                $month = $monthIndex + 1;
            }
        }
        if (isset($dateMap['month_full'])) {
            $monthIndex = static::getIndexFromMonths($dateMap['month_full']);
            if ($monthIndex !== null) {
                $month = $monthIndex + 1;
            }
        }
        if (isset($dateMap['month'])) {
            $month = (int) $dateMap['month'];
        }

        // --- DAY ---
        if (isset($dateMap['day'])) {
            $day = (int) $dateMap['day'];
        }

        // --- HOUR 12 ---
        $hour12 = null;
        if (isset($dateMap['hour12'])) {
            $hour12 = (int) $dateMap['hour12'];
        }
        if (isset($dateMap['ampm'])) {
            $ampm = strtolower($dateMap['ampm']);
            if ($ampm === 'pm' && $hour12 !== null && $hour12 < 12) {
                $hour = 12 + $hour12;
            } elseif ($ampm === 'am' && $hour12 === 12) {
                $hour = 0;
            } else {
                $hour = $hour12 ?? $hour;
            }
        }
        if (isset($dateMap['hour24'])) {
            $hour = (int) $dateMap['hour24'];
        }

        // --- MINUTE ---
        if (isset($dateMap['minute'])) {
            $minute = (int) $dateMap['minute'];
        }

        // --- SECOND ---
        if (isset($dateMap['second'])) {
            $second = (int) $dateMap['second'];
        }

        $date = new static($year ?? $now->year, $month ?? $now->month, $day ?? 1, $hour, $minute, $second, $timezone);
        if (! $day) {
            if (isset($dateMap['weekday_num'])) {
                return $date->shiftToNearWeek((int) $dateMap['weekday_num']);
            }
            if (isset($dateMap['weekday_short'])) {
                $weekday = static::getIndexFromShortWeekDays($dateMap['weekday_short']);
                if ($weekday !== null) {
                    return $date->shiftToNearWeek($weekday + 1);
                }
            }
            if (isset($dateMap['weekday_full'])) {
                $weekday = static::getIndexFromWeekDays($dateMap['weekday_full']);
                if ($weekday !== null) {
                    return $date->shiftToNearWeek($weekday + 1);
                }
            }
        }

        return $date;
    }

    protected static function getTimezoneFromMatches(array $matches): DateTimeZone
    {
        if (isset($matches['timezone'])) {
            try {
                return new DateTimeZone($matches['timezone']);
            } catch (Exception $e) {
                return new DateTimeZone('Asia/Kathmandu');
            }
        }
        if (isset($matches['timezone_offset'])) {
            $offset = $matches['timezone_offset'];
            $sign = ($offset[0] === '-') ? -1 : 1;
            $hours = (int) substr($offset, 1, 2);
            $minutes = (int) substr($offset, 3, 2);

            return new DateTimeZone(sprintf('UTC%s%02d:%02d', $sign < 0 ? '-' : '+', $hours, $minutes));
        }

        if (isset($matches['timezone_offset_colon'])) {
            $offset = $matches['timezone_offset_colon'];
            $sign = ($offset[0] === '-') ? -1 : 1;
            [$hours, $minutes] = explode(':', substr($offset, 1));

            return new DateTimeZone(sprintf('UTC%s%02d:%02d', $sign < 0 ? '-' : '+', $hours, $minutes));
        }

        if (! empty($matches['timezone_seconds'])) {
            $seconds = (int) $matches['timezone_seconds'];
            $sign = $seconds < 0 ? '-' : '+';
            $seconds = abs($seconds);
            $hours = floor($seconds / 3600);
            $minutes = ($seconds % 3600) / 60;

            return new DateTimeZone(sprintf('UTC%s%02d:%02d', $sign, $hours, $minutes));
        }

        return new DateTimeZone('Asia/Kathmandu');
    }
}
