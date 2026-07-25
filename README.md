# NepaliDate — Nepali Date (Bikram Sambat / BS) for PHP & Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rohanadhikari/nepali-date.svg?style=flat-square)](https://packagist.org/packages/rohanadhikari/nepali-date)
[![Total Downloads](https://img.shields.io/packagist/dt/rohanadhikari/nepali-date.svg?style=flat-square)](https://packagist.org/packages/rohanadhikari/nepali-date)
[![License: MIT](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](./LICENSE.md)
[![PHP Version](https://img.shields.io/badge/php-%5E8.1-777bb4.svg?style=flat-square)](https://www.php.net/)

**NepaliDate** is a dependency-free PHP library for working with the **Nepali calendar (Bikram Sambat / BS)** — the calendar of Nepal. It converts between **AD (Gregorian) and BS**, formats, parses, compares, and manipulates Nepali dates with a fluent, [Carbon](https://carbon.nesbot.com/)-inspired API, and ships first-class **Laravel** support (Eloquent casts, validation rules, and Blade directives).

Whether you're building a Nepali government portal, a Nepal-based e-commerce app, a school/attendance system, or just need accurate **AD ⇄ BS date conversion** in PHP, NepaliDate gives you a complete, tested toolkit instead of hand-rolled conversion math.

---

## ✨ Features

- 🕒 Full **Nepali (BS) date and time** support — not just year/month/day conversion
- 🗓 Simple, accurate conversion **between AD and BS**, optimized for bulk conversion — see [Performance](./docs/PERFORMANCE.md)
- 🔁 Both **mutable** (`NepaliDate`) and **immutable** (`NepaliDateImmutable`) variants
- ➕ Add, subtract, and snap dates by year, month, day, hour, minute, or second
- 🌐 Built-in **Nepali (`np`) and English (`en`) locales**, with full customization support
- 🔢 Format dates with `date()`-style tokens, or use predefined format constants
- 🔍 Rich comparison API — `isToday()`, `isWeekend()`, `between()`, and more
- 🧩 **Laravel-ready**: Eloquent casts, form validation rules, and Blade directives out of the box
- 🔤 Standalone `NepaliNumbers` utility for digit, currency, and word conversion

---

## 📦 Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require rohanadhikari/nepali-date
```

No other setup is required for plain PHP. In Laravel, the service provider is auto-discovered — see [Laravel Integration](./docs/LARAVEL.md).

---

## 🚀 Quick Start

```php
use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

// Current Nepali date and time
$now = NepaliDate::now();

// Parse a natural-language notation and manipulate it
$date = NepaliDate::fromNotation('tomorrow');
$date->addDays(5);

// Convert to Gregorian (AD)
$adDate = $date->toAd();

// Format it
echo $date->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// e.g. 2082-06-30 14:45:22

// Immutable variant — every mutation returns a new instance
$immutableNow = NepaliDateImmutable::now();
$newDate = $immutableNow->addDays(10); // original is unchanged
```

> [!NOTE]
> Predefined format constants are listed in [Constants](./docs/CONSTANTS.md).

### Using in plain PHP (no framework)

```php
require __DIR__ . '/vendor/autoload.php';

use RohanAdhikari\NepaliDate\NepaliDate;

$now = NepaliDate::now();
echo $now->format(NepaliDate::FORMAT_DATETIME_24_FULL);

$ad = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));
echo NepaliDate::fromAd($ad)->format(NepaliDate::FORMAT_DATE_YMD);
```

Make sure the path to `vendor/autoload.php` is correct relative to your script — Composer is the recommended way to load the package.

---

## 📖 Documentation

The core README covers the essentials; everything else lives in [`docs/`](./docs), organized by topic (Carbon-style) so you only read what you need:

| Guide                                             | Covers                                                                        |
| ------------------------------------------------- | ----------------------------------------------------------------------------- |
| [Initialization](./docs/INITIALIZATION.md)        | `now()`, `fromAd()`, `fromNotation()`, `fromTimestamp()`, direct construction |
| [Formatting](./docs/FORMATTING.md)                | Format tokens, examples, locale-aware output                                  |
| [Parsing](./docs/PARSING.md)                      | `parse()`, `createFromFormat()`, custom parse patterns                        |
| [Arithmetic & Shifting](./docs/ARITHMETIC.md)     | Add/subtract units, month overflow control, diff, timezone/week shifting      |
| [Getters](./docs/GETTERS.md)                      | Year, time, day, month, timezone, and locale-based accessors                  |
| [Setters](./docs/SETTERS.md)                      | Basic, unit-based, and combined setters                                       |
| [Boundaries](./docs/BOUNDARIES.md)                | `startOf()`/`endOf()` for day, week, month, quarter, year, decade...          |
| [Comparison](./docs/COMPARISON.md)                | `eq()`, `between()`, `isToday()`, `isWeekend()`, and other state checks       |
| [Constants](./docs/CONSTANTS.md)                  | Weekday, month, locale, and format constants                                  |
| [Locale Customization](./docs/LOCALECUSTOMIZE.md) | Customizing month/weekday names per locale                                    |
| [Macros](./docs/MACRO.md)                         | Adding custom methods at runtime                                              |
| [Nepali Numbers](./docs/NEPALINUMBERS.md)         | Digit, currency, and word conversion utilities                                |
| [Calendar](./docs/CALENDER.md)                    | Low-level BS/AD calendar math and lookup tables                               |
| [Exceptions](./docs/EXCEPTIONS.md)                | What can be thrown, and how to guard against it                               |
| [Laravel Integration](./docs/LARAVEL.md)          | Eloquent casts, validation rules, Blade directives                            |
| [Performance](./docs/PERFORMANCE.md)              | Bulk-conversion results and practical guidance for high-throughput usage      |

---

## 🌐 Locale

Available locales: `en` and `np`.

```php
$date = NepaliDate::now();
$date->setLocale(NepaliDate::NEPALI); // or ->locale('np')

echo $date->format(NepaliDate::FORMAT_DATETIME_24);
// Example Output: २०८२-०६-३१ २१:३४

$date->resetLocale();
```

> [!NOTE]
> Set a global default for every new instance with `NepaliDate::defaultLocale(NepaliDate::NEPALI)`. See [Locale Customization](./docs/LOCALECUSTOMIZE.md) to change the underlying month/weekday names.

---

## Nepali Date in Laravel

Using Nepali date in Laravel is a first-class use case for this package: Eloquent casts, form validation rules, and Blade directives (`@nepaliDate`, `@nepaliNow`, `@nepaliWeekend`, ...) are all included and auto-registered via a Laravel service provider — no extra config. See the [Laravel Integration Guide](./docs/LARAVEL.md) (with FAQ) for the full reference.

```php
use RohanAdhikari\NepaliDate\Laravel\Casts\ADAsNepaliDate;

class Post extends Model
{
    protected function casts(): array
    {
        return ['published_at' => ADAsNepaliDate::class];
    }
}
```

```blade
<p>Published: @nepaliDate($post->published_at, 'l, F j, Y')</p>
```

---

## 🧪 Testing

```bash
composer test        # Run the Pest test suite
composer analyse     # Run PHPStan static analysis
composer format       # Run Laravel Pint
composer time:check    # Benchmark AD <-> BS conversion — see docs/PERFORMANCE.md
```

---

## 🤝 Contributing

Contributions are welcome and will be fully credited. Please read the [Contributing Guide](./.github/CONTRIBUTING.md) before opening an issue or pull request.

## 🔒 Security

If you discover a security vulnerability, please see [SECURITY.md](./.github/SECURITY.md) for responsible disclosure instructions instead of using the public issue tracker.

## 📄 License

The MIT License (MIT). See [LICENSE.md](./LICENSE.md) for details.
