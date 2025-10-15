<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\Traits\DateConverter;
use RohanAdhikari\NepaliDate\Traits\haveDateFormats;
use RohanAdhikari\NepaliDate\Traits\haveDateGetters;
use RohanAdhikari\NepaliDate\Traits\haveDateParse;
use RohanAdhikari\NepaliDate\Traits\haveDateSetters;
use RohanAdhikari\NepaliDate\Traits\haveImmutable;
use RohanAdhikari\NepaliDate\Traits\useBoundaries;
use RohanAdhikari\NepaliDate\Traits\useComparison;
use RohanAdhikari\NepaliDate\Traits\useLocale;
use RohanAdhikari\NepaliDate\Traits\useMacro;
use RohanAdhikari\NepaliDate\Traits\useMagicMethods;
use RohanAdhikari\NepaliDate\Traits\useOverFlowBounds;
use RohanAdhikari\NepaliDate\Traits\useUnitArithmetic;

/**
 * @property int $year
 * @property int $month
 * @property int $day
 * @property int $dayOfWeek
 * @property int $hour
 * @property int $minute
 * @property int $second
 * @property DateTimeZone $timezone
 */
class NepaliDate implements NepaliDateInterface
{
    use DateConverter;
    use haveDateFormats;
    use haveDateGetters, haveDateSetters, haveImmutable;
    use haveDateParse;
    use useBoundaries;
    use useComparison;
    use useLocale, useMacro;
    use useMagicMethods;
    use useOverFlowBounds;
    use useUnitArithmetic;

    protected int $year;

    protected int $month;

    protected int $day;

    protected int $dayOfWeek;

    protected int $hour;

    protected int $minute;

    protected int $second;

    protected DateTimeZone $timezone;

    public function __construct(
        int $year,
        int $month,
        int $day,
        int $hour = 0,
        int $minute = 0,
        int $second = 0,
        string|DateTimeZone $timezone = 'Asia/Kathmandu'
    ) {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
        $this->timezone = static::resolveTimeZone($timezone);
        $this->dayOfWeek = Calendar::calculateDayOfWeek($year, $month, $day);
    }

    protected function resolve(NepaliDateInterface|string|null $date): NepaliDateInterface
    {
        if (! $date) {
            return static::now();
        }
        if ($date instanceof NepaliDateInterface) {
            return $date;
        }

        return static::parse($date);
    }

    protected static function resolveTimeZone(DateTimeZone|string|null $timezone): DateTimeZone
    {
        if (! $timezone) {
            $timezone = 'Asia/Kathmandu';
        }
        if ($timezone instanceof DateTimeZone) {
            return $timezone;
        }

        return new DateTimeZone($timezone);
    }

    public static function fromInstance(NepaliDateInterface $instance): static
    {
        return new static(
            $instance->getYear(),
            $instance->getMonth(),
            $instance->getDay(),
            $instance->getHour(),
            $instance->getMinute(),
            $instance->getSecond(),
            $instance->getTimezone()->getName()
        );
    }

    public static function fromAd(DateTime $datetime): static
    {
        $adyear = (int) $datetime->format('Y');
        $admonth = (int) $datetime->format('m');
        $adday = (int) $datetime->format('d');
        $hour = (int) $datetime->format('H');
        $minute = (int) $datetime->format('i');
        $second = (int) $datetime->format('s');
        $timezone = $datetime->getTimezone()->getName();
        [$year, $month, $day] = static::ADtoBS($adyear, $admonth, $adday);

        return new static($year, $month, $day, $hour, $minute, $second, $timezone);
    }

    public static function fromNotation(string $notation, string|DateTimeZone $timezone = 'Asia/Kathmandu'): static
    {
        try {
            $adDate = new DateTime($notation, static::resolveTimeZone($timezone));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("Invalid date notation: $notation");
        }

        return static::fromAd($adDate);
    }

    public static function fromTimestamp(int $timestamp, string|DateTimeZone $timezone = 'Asia/Kathmandu'): static
    {
        try {
            $adDate = new DateTime('@' . $timestamp, static::resolveTimeZone($timezone));
        } catch (\Exception $e) {
            throw new \InvalidArgumentException("Invalid timestamp: $timestamp");
        }

        return static::fromAd($adDate);
    }

    public static function now(string|DateTimeZone $timezone = 'Asia/Kathmandu'): static
    {
        $adDate = new DateTime('now', static::resolveTimeZone($timezone));

        return static::fromAd($adDate);
    }

    public function toAd(): DateTimeInterface
    {
        [$year, $month, $day] = static::BStoAD($this->year, $this->month, $this->day);
        $timezone = $this->getTimezone();
        if ($this->isImmutable()) {
            return (new DateTimeImmutable('now', $timezone))
                ->setDate($year, $month, $day)
                ->setTime($this->hour, $this->minute, $this->second);
        }
        $date = new DateTime('now', $timezone);
        $date->setDate($year, $month, $day);
        $date->setTime($this->hour, $this->minute, $this->second);

        return $date;
    }

    public function __toString()
    {
        return $this->format(NepaliDateInterface::FORMAT_DATETIME_24_FULL);
    }

    public function toDateString(): string
    {
        return $this->format(NepaliDateInterface::FORMAT_DATE_YMD);
    }

    public function getTimestamp(): int
    {
        return $this->toAd()->getTimestamp();
    }

    public function nowWithSameTz(): NepaliDateInterface
    {
        return static::now($this->getTimezone());
    }
}
