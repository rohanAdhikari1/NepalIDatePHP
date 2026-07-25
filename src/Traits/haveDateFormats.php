<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

use DateTimeInterface;

trait haveDateFormats
{
    public function format(string $format): string
    {
        $usedTokens = array_flip(str_split($format));
        $handlers = $this->formatTokenHandlers();
        $replacements = [];

        foreach ($usedTokens as $token => $_) {
            if (isset($handlers[$token])) {
                $replacements[$token] = $handlers[$token]();
            }
        }

        return strtr($format, $replacements);
    }

    /**
     * @return array<string, callable(): string>
     */
    private function formatTokenHandlers(): array
    {
        $adDate = null;
        $resolveAd = function () use (&$adDate): DateTimeInterface {
            return $adDate ??= $this->toAd();
        };

        return [
            // Year
            'Y' => fn () => $this->getLocaleYear(),
            'y' => fn () => $this->getLocaleShortYear(),

            // Month
            'm' => fn () => $this->getLocaleTwoDigitMonth(),
            'n' => fn () => $this->getLocaleMonth(),
            'M' => fn () => $this->getLocaleShortMonthName(),
            'F' => fn () => $this->getLocaleMonthName(),

            // Day
            'd' => fn () => $this->getLocaleTwoDigitDay(),
            'j' => fn () => $this->getLocaleDay(),

            // Week Day
            'D' => fn () => $this->getLocaleShortWeekDayName(),
            'l' => fn () => $this->getLocaleWeekDayName(),
            // S  Needs implementation Ordinal suffix (Available sson)
            'w' => fn () => $this->getLocaleWeekDay(),

            // Time - 24-hour
            'H' => fn () => $this->getLocaleTwoDigitHour(),
            'G' => fn () => $this->getLocaleHour(),

            // Time - 12-hour
            'h' => fn () => $this->getLocaleTwoDigitShortHour(),
            'g' => fn () => $this->getLocaleShortHour(),
            'a' => fn () => strtolower($this->getLocaleMaridian()),
            'A' => fn () => $this->getLocaleMaridian(),

            // Minutes and seconds
            'i' => fn () => $this->getLocaleTwoDigitMinute(),
            's' => fn () => $this->getLocaleTwoDigitSecond(),

            // Timezone
            'e' => fn () => $this->timezone->getName(),
            'O' => fn () => $resolveAd()->format('O'), // +0530
            'P' => fn () => $resolveAd()->format('P'),  // +05:30
            'Z' => fn () => $resolveAd()->format('Z'),

            // Formats
            'c' => fn () => sprintf(
                '%s-%s-%sT%s:%s:%s%s',
                $this->getLocaleYear(),
                $this->getLocaleTwoDigitMonth(),
                $this->getLocaleTwoDigitDay(),
                $this->getLocaleTwoDigitHour(),
                $this->getLocaleTwoDigitMinute(),
                $this->getLocaleTwoDigitSecond(),
                $resolveAd()->format('P')
            ),
            'r' => fn () => sprintf(
                '%s, %s %s %s %s:%s:%s %s',
                $this->getLocaleShortWeekDayName(),
                $this->getLocaleTwoDigitDay(),
                $this->getLocaleShortMonthName(),
                $this->getLocaleYear(),
                $this->getLocaleTwoDigitHour(),
                $this->getLocaleTwoDigitMinute(),
                $this->getLocaleTwoDigitSecond(),
                $resolveAd()->format('O')
            ),
            // ad timestamp
            'U' => fn () => (string) $resolveAd()->getTimestamp(),
        ];
    }
}
