<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use DateTimeZone;
use RohanAdhikari\NepaliDate\Constants\Calendar;
use RohanAdhikari\NepaliDate\NepaliNumbers;

trait haveDateGetters
{
    public function getMillennium(): int
    {
        return (int) ceil($this->year / 1000);
    }

    public function getCentury(): int
    {
        return (int) ceil($this->year / 100);
    }

    public function getDecade(): int
    {
        return (int) ceil($this->year / 10);
    }

    /**
     * Get the year.
     */
    public function getYear(): int
    {
        return $this->year;
    }

    public function getShortYear(): string
    {
        return substr((string) $this->getYear(), -2);
    }

    /**
     * Get the month number (1-12).
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * Get the month as a two-digit string.
     */
    public function getTwoDigitMonth(): string
    {
        return NepaliNumbers::getTwoDigitNumber($this->getMonth());
    }

    public function getQuarter(): int
    {
        return (int) ceil($this->month / 3);
    }

    /**
     * Get the day number.
     */
    public function getDay(): int
    {
        return $this->day;
    }

    public function getTwoDigitDay(): string
    {
        return NepaliNumbers::getTwoDigitNumber($this->getDay());
    }

    /**
     * Get the day of the week (1 = Sunday, 7 = Saturday).
     */
    public function getWeekDay(): int
    {
        return $this->dayOfWeek;
    }

    /**
     * Get the hour (0-23).
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    public function getTwoDigitHour(): string
    {
        return NepaliNumbers::getTwoDigitNumber($this->getHour());
    }

    public function getShortHour(): int
    {
        $shortHour = (($this->getHour() - 1) % 12) + 1;

        return $shortHour == 0 ? 12 : $shortHour;
    }

    public function getTwoDigitShortHour(): string
    {
        return NepaliNumbers::getTwoDigitNumber($this->getShortHour());
    }

    /**
     * Get the minute (0-59).
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    public function getTwoDigitMinute(): string
    {
        return NepaliNumbers::getTwoDigitNumber($this->getMinute());
    }

    /**
     * Get the second (0-59).
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    public function getTwoDigitSecond(): string
    {
        return NepaliNumbers::getTwoDigitNumber($this->getSecond());
    }

    public function getMaridian(): string
    {
        if ($this->getHour() < 12) {
            return 'AM';
        }

        return 'PM';
    }

    /**
     * Get the timezone object.
     */
    public function getTimezone(): DateTimeZone
    {
        return $this->timezone;
    }

    public function getTimezoneName(): string
    {
        return $this->getTimezone()->getName();
    }

    public function getTZName(): string
    {
        return $this->getTimezoneName();
    }

    /* ==================== Locale Representations ==================== */

    public function getLocaleMillennium(): string
    {
        return $this->convertNumberToLocale($this->getMillennium());
    }

    public function getLocaleCentury(): string
    {
        return $this->convertNumberToLocale($this->getMillennium());
    }

    public function getLocaleDecade(): string
    {
        return $this->convertNumberToLocale($this->getMillennium());
    }

    public function getLocaleYear(): string
    {
        return $this->convertNumberToLocale($this->getYear());
    }

    public function getLocaleShortYear(): string
    {
        return $this->convertNumberToLocale($this->getShortYear());
    }

    public function getLocaleQuarter(): string
    {
        return $this->convertNumberToLocale($this->getMillennium());
    }

    public function getLocaleMonth(): string
    {
        return $this->convertNumberToLocale($this->getMonth());
    }

    public function getLocaleTwoDigitMonth(): string
    {
        return $this->convertNumberToLocale($this->getTwoDigitMonth());
    }

    public function getLocaleMonthName(): string
    {
        return $this->getMonthFromLocale($this->getMonth());
    }

    public function getLocaleShortMonthName(): string
    {
        return $this->getShortMonthFromLocale($this->getMonth());
    }

    public function getLocaleWeekDay(): string
    {
        return $this->convertNumberToLocale($this->getWeekDay());
    }

    public function getLocaleWeekDayName(): string
    {
        return $this->getWeekDayFromLocale($this->getWeekDay());
    }

    public function getLocaleShortWeekDayName(): string
    {
        return $this->getShortWeekDayFromLocale($this->getWeekDay());
    }

    public function getLocaleDay(): string
    {
        return $this->convertNumberToLocale($this->getDay());
    }

    public function getLocaleTwoDigitDay(): string
    {
        return $this->convertNumberToLocale($this->getTwoDigitDay());
    }

    public function getLocaleHour(): string
    {
        return $this->convertNumberToLocale($this->getHour());
    }

    public function getLocaleShortHour(): string
    {
        return $this->convertNumberToLocale($this->getShortHour());
    }

    public function getLocaleTwoDigitShortHour(): string
    {
        return $this->convertNumberToLocale($this->getTwoDigitShortHour());
    }

    public function getLocaleTwoDigitHour(): string
    {
        return $this->convertNumberToLocale($this->getTwoDigitShortHour());
    }

    public function getLocaleMinute(): string
    {
        return $this->convertNumberToLocale($this->getMinute());
    }

    public function getLocaleTwoDigitMinute(): string
    {
        return $this->convertNumberToLocale($this->getTwoDigitMinute());
    }

    public function getLocaleSecond(): string
    {
        return $this->convertNumberToLocale($this->getSecond());
    }

    public function getLocaleTwoDigitSecond(): string
    {
        return $this->convertNumberToLocale($this->getTwoDigitSecond());
    }

    public function getLocaleMaridian(): string
    {
        // TODO: Return Maridian as per Locale
        return $this->getMaridian();
    }

    public function getDaysInMonth(): int
    {
        return Calendar::getDaysInBSMonth($this->year, $this->month);
    }

    protected function handleDynamicGet(string $name): mixed
    {
        $method = 'get'.ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }
}
