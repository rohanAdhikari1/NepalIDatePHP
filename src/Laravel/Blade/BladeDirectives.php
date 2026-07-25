<?php

declare(strict_types=1);

namespace RohanAdhikari\NepaliDate\Laravel\Blade;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Support\Facades\Blade;
use RohanAdhikari\NepaliDate\Laravel\ServiceProvider;
use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateInterface;

/**
 * Registers Blade echo directives
 *
 * @see ServiceProvider
 */
class BladeDirectives
{
    public static function register(): void
    {
        static::registerDirectives();
        static::registerConditionals();
    }

    protected static function registerDirectives(): void
    {
        // @nepaliDate($date, $format = null) — defaults to FORMAT_DATE_YMD
        Blade::directive('nepaliDate', function (string $expression) {
            return "<?php echo e(\RohanAdhikari\NepaliDate\Laravel\Blade\BladeDirectives::formatDate({$expression})); ?>";
        });

        // @nepaliDateTime($date, $format = null) — defaults to FORMAT_DATETIME_24_FULL
        Blade::directive('nepaliDateTime', function (string $expression) {
            return "<?php echo e(\RohanAdhikari\NepaliDate\Laravel\Blade\BladeDirectives::formatDateTime({$expression})); ?>";
        });

        // @nepaliNow($format = null) — current Nepali date/time
        Blade::directive('nepaliNow', function (string $expression) {
            return "<?php echo e(\RohanAdhikari\NepaliDate\Laravel\Blade\BladeDirectives::formatNow({$expression})); ?>";
        });

        // @nepaliNumber($number) — English digits to Nepali numerals
        Blade::directive('nepaliNumber', function (string $expression) {
            return "<?php echo e(\RohanAdhikari\NepaliDate\NepaliNumbers::convertToNepali({$expression})); ?>";
        });

        // @nepaliCurrency($amount, $symbol = true, $only = false, $format = true, $locale = 'np')
        Blade::directive('nepaliCurrency', function (string $expression) {
            return "<?php echo e(\RohanAdhikari\NepaliDate\NepaliNumbers::getNepaliCurrency({$expression})); ?>";
        });
    }

    protected static function registerConditionals(): void
    {
        // @nepaliWeekend($date = null) ... @elsenepaliWeekend ... @endnepaliWeekend
        Blade::if('nepaliWeekend', function (mixed $date = null): bool {
            return static::resolve($date)->isWeekend();
        });

        // @nepaliToday($date = null) ... @endnepaliToday
        Blade::if('nepaliToday', function (mixed $date = null): bool {
            return static::resolve($date)->isToday();
        });

        // @nepaliFuture($date = null) ... @endnepaliFuture
        Blade::if('nepaliFuture', function (mixed $date = null): bool {
            return static::resolve($date)->isFuture();
        });

        // @nepaliPast($date = null) ... @endnepaliPast
        Blade::if('nepaliPast', function (mixed $date = null): bool {
            return static::resolve($date)->isPast();
        });
    }

    public static function formatDate(mixed $date = null, ?string $format = null): string
    {
        return static::resolve($date)->format($format ?? NepaliDateInterface::FORMAT_DATE_YMD);
    }

    public static function formatDateTime(mixed $date = null, ?string $format = null): string
    {
        return static::resolve($date)->format($format ?? NepaliDateInterface::FORMAT_DATETIME_24_FULL);
    }

    public static function formatNow(?string $format = null): string
    {
        return NepaliDate::now()->format($format ?? NepaliDateInterface::FORMAT_DATETIME_24_FULL);
    }

    /**
     * Resolve a NepaliDate/Carbon/DateTime/string/null value into a NepaliDateInterface instance.
     */
    protected static function resolve(mixed $date): NepaliDateInterface
    {
        if ($date === null) {
            return NepaliDate::now();
        }

        if ($date instanceof NepaliDateInterface) {
            return $date;
        }

        if ($date instanceof DateTimeInterface) {
            return NepaliDate::fromAd($date instanceof DateTimeImmutable ? DateTime::createFromImmutable($date) : $date);
        }

        return NepaliDate::parse((string) $date);
    }
}
