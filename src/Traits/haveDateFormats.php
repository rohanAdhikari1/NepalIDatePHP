<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait haveDateFormats
{
    public function format(string $format): string
    {
        $replacements = [
            // Year
            'Y' => $this->getLocaleYear(),
            'y' => $this->getLocaleShortYear(),

            // Month
            'm' => $this->getLocaleTwoDigitMonth(),
            'n' => $this->getLocaleMonth(),
            'M' => $this->getLocaleShortMonthName(),
            'F' => $this->getLocaleMonthName(),

            // Day
            'd' => $this->getLocaleTwoDigitDay(),
            'j' => $this->getLocaleDay(),

            // Week Day
            'D' => $this->getLocaleShortWeekDayName(),
            'l' => $this->getLocaleWeekDayName(),
            // S  Needs implementation Ordinal suffix (Available sson)
            'w' => $this->getLocaleWeekDay(),

            // Time - 24-hour
            'H' => $this->getLocaleTwoDigitHour(),
            'G' => $this->getLocaleHour(),

            // Time - 12-hour
            'h' => $this->getLocaleTwoDigitShortHour(),
            'g' => $this->getLocaleShortHour(),
            'a' => strtolower($this->getLocaleMaridian()),
            'A' => $this->getLocaleMaridian(),

            // Minutes and seconds
            'i' => $this->getLocaleTwoDigitMinute(),
            's' => $this->getLocaleTwoDigitSecond(),

            // Timezone
            'e' => $this->timezone->getName(),
            'O' => $this->toAd()->format('O'), // +0530
            'P' => $this->toAd()->format('P'),  // +05:30
            'Z' => $this->toAd()->format('Z'),

            // Formats
            'c' => sprintf(
                '%s-%s-%sT%s:%s:%s%s',
                $this->getLocaleYear(),
                $this->getLocaleTwoDigitMonth(),
                $this->getLocaleTwoDigitDay(),
                $this->getLocaleTwoDigitHour(),
                $this->getLocaleTwoDigitMinute(),
                $this->getLocaleTwoDigitSecond(),
                $this->toAd()->format('P')
            ),
            'r' => sprintf(
                '%s, %s %s %s %s:%s:%s %s',
                $this->getLocaleShortWeekDayName(),
                $this->getLocaleTwoDigitDay(),
                $this->getLocaleShortMonthName(),
                $this->getLocaleYear(),
                $this->getLocaleTwoDigitHour(),
                $this->getLocaleTwoDigitMinute(),
                $this->getLocaleTwoDigitSecond(),
                $this->toAd()->format('O')
            ),
            // ad timestamp
            'U' => (string) $this->getTimestamp(),
        ];

        return strtr($format, $replacements);
    }
}
