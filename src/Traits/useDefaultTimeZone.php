<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Traits;

trait useDefaultTimeZone
{
    protected static ?string $defaultTimezoneName = null;

    public static function getDefaultTimeZoneName(): string
    {
        return static::$defaultTimezoneName ?? 'Asia/Kathmandu';
    }

    public static function setDefaultTimeZoneName(string $timezone): void
    {
        static::$defaultTimezoneName = $timezone;
    }

    public static function resetTimeZone(): void
    {
        static::$defaultTimezoneName = null;
    }
}
