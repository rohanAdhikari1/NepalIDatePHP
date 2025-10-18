# NepaliDate

A PHP package for handling **Nepali Date and Time (Bikram Sambat - BS)** with full support for localization, date manipulation, and formatting. All calculations are based on the **Nepali calendar**, making it perfect for applications targeting Nepali users or systems that operate primarily in BS.

---

## 🚀 Features

- 🕒 Works in **Nepali (BS) date and time**
- 🗓 Simple function to **convert between AD & BS**
- 🔁 Support for **mutable** and **immutable** date handling
- ➕ Add or subtract days, months, and years in BS
- 📅 Get current Nepali date and time
- 🌐 Customizable **locale** (Nepali or English)
- 🔢 Format dates in various display styles
- ⚙️ Compare, parse, and format dates easily
- 🧩 Integration-ready with Laravel and other frameworks

---

## 📦 Installation

Install via [Composer](https://getcomposer.org/):

```bash
composer require rohanadhikari/nepali-date
```

---

## Usage

```php
use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

// -----------------------------
// Mutable NepaliDate
// -----------------------------
$now = NepaliDate::now(); // Current Nepali date and time

$date = NepaliDate::fromNotation('tomorrow'); // Parse a notation
$date->addDays(5);                            // Add 5 days

$adDate = $date->toAd();                       // Convert to Gregorian (AD)

$formatted = $date->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// Example: 2082-06-30 14:45:22

// -----------------------------
// Immutable NepaliDate
// -----------------------------
$immutableNow = NepaliDateImmutable::now();   // Immutable current date

$immutableDate = $date->cast();               // Cast mutable to immutable and vice versa
// or
$immutableDate = $date->toImmutable();

$newDate = $immutableDate->addDays(10);       // Returns a new instance, original remains unchanged
```

> [!NOTE]  
> You can see the available constants [here](./docs/CONSTANTS.md)

## Using in native PHP (no framework)

If you're not using a framework, you can still use this package in plain PHP. The easiest way is to install via Composer and include the generated autoloader.

```php
// Require Composer's autoloader (adjust path as needed)
require __DIR__ . '/vendor/autoload.php';

use RohanAdhikari\NepaliDate\NepaliDate;
use RohanAdhikari\NepaliDate\NepaliDateImmutable;

// -----------------------------
// Mutable example
// -----------------------------
$now = NepaliDate::now();
echo $now->format(NepaliDate::FORMAT_DATETIME_24_FULL);

// -----------------------------
// Immutable example
// -----------------------------
$immutable = NepaliDateImmutable::now();
$new = $immutable->addDays(5); // returns a new instance
echo $new->format(NepaliDate::FORMAT_DATE_YMD);

// -----------------------------
// Create from native DateTime (AD)
// -----------------------------
$ad = new DateTime('now', new DateTimeZone('Asia/Kathmandu'));
$fromAd = NepaliDate::fromAd($ad);
echo $fromAd->format(NepaliDate::FORMAT_DATE_YMD);
```

Notes:

- Make sure `vendor/autoload.php` path is correct relative to your script.
- Composer is the recommended way to load the package. If you don't use Composer you would need to include the package files manually (not recommended).

---

## ⚙️ Initialize

Create a new **NepaliDate** instance in different ways depending on your use case.

---

### Now

Returns a `NepaliDate` instance initialized with the **current Nepali date and time**.

**Parameters:**

- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$now = NepaliDate::now();
echo $now->format(NepaliDate::FORMAT_DATETIME_12_FULL); // 2082-06-30 10:09:38 PM
//you can also specify timezone as
$now = NepaliDate::now('Asia/Kathmandu');
//or
$timezone = new DateTimeZone('Asia/Kathmandu');
NepaliDate::now($timezone);
```

---

### Using PHP Native DateTime

Create a `NepaliDate` instance directly from a PHP native `DateTime` (AD).  
This automatically converts the **Gregorian (AD)** date into the **Nepali (BS)** calendar.

```php
use RohanAdhikari\NepaliDate\NepaliDate;
$date = new DateTime();
$nepalidate = NepaliDate::fromAd($date);
echo $nepaliDate->format(NepaliDate::FORMAT_DATE_YMD); // 2082-06-30
```

---

### Using DateTime Notation

Create a `NepaliDate` instance using a **natural language date string** (like `'now'`, `'yesterday'`, `'tomorrow'`).  
This internally parses the notation using Native DateTime and converts it into a corresponding **Nepali (BS)** date.

- `notation` — A date string supported by PHP’s native `DateTime` parser (e.g., `'now'`, `'yesterday'`, `'2025-01-01'`, `'next monday'`).
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

**Example**

```php
use RohanAdhikari\NepaliDate\NepaliDate;
// Create NepaliDate for tomorrow and format it
$nepaliDate = NepaliDate::fromNotation('tomorrow');

echo $nepaliDate->format(NepaliDate::FORMAT_DATE_YMD); // e.g. 2082-06-31
```

---

### Using Unix Timestamp

Create a `NepaliDate` instance from a **Unix timestamp**.  
This method first converts the timestamp into a PHP `DateTime` object and then translates it into the equivalent **Nepali (BS)** date and time.

**Parameters**

- `timestamp` — A valid Unix timestamp (seconds since Unix epoch).
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.
  **Example**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDate::fromTimestamp(1760632252);

echo $nepaliDate->format(NepaliDate::FORMAT_DATETIME_24_FULL); // e.g. 2082-06-30 22:15:52
```

---

### Direct

Manually create a new `NepaliDate` instance by providing all date components.

**Parameters**

- `year` - Nepali year (e.g. `2082`)
- `month` - Nepali month number (`1–12`)
- `day` — Day of month (`1–32`, varies by **year** and **month**)
- `hour` _(optional)_ — Defaults to `0`
- `minute` _(optional)_ — Defaults to `0`
- `second` _(optional)_ — Defaults to `0`
- `timezone` _(optional)_ — Defaults to `'Asia/Kathmandu'`.

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepalidate = new NepaliDate(2082,6,30,timezone:'Asia/kathmandu')
```

---

## Format

Formats the `NepaliDate` instance according to the provided pattern and locale-specific rules, and returns a string of the formatted date. You can also use predefined fromat pattern from [Constants](./docs/CONSTANTS.md#date-formats).

**List of Available Formats Tokens**

| Format | Output Example                  | Meaning                                 |
| ------ | ------------------------------- | --------------------------------------- |
| Y      | 2082                            | Year                                    |
| y      | 82                              | Two-digit year                          |
| m      | 2                               | Month (1–12)                            |
| n      | 02                              | Month, two digits                       |
| M      | Bai                             | Short month name                        |
| F      | Baisakh                         | Full month name                         |
| d      | 09                              | Two-digit day                           |
| j      | 9                               | Day                                     |
| D      | Sun                             | Short weekday name                      |
| l      | Sunday                          | Full weekday name                       |
| w      | 1                               | Weekday number (Sunday=1, Monday=2…)    |
| G      | 7                               | Hour, 24-hour clock                     |
| H      | 07                              | Hour, 24-hour clock, 2-digits           |
| h      | 23                              | Hour, 12-hour clock                     |
| g      | 12                              | Hour, 12-hour clock, 2-digits           |
| a      | am / pm                         | Meridiem (lowercase)                    |
| A      | AM / PM                         | Meridiem (uppercase)                    |
| i      | 59                              | Minute, 2-digits                        |
| s      | 59                              | Second, 2-digits                        |
| e      | Asia/Kathmandu                  | Timezone name                           |
| O      | +0530                           | Timezone offset                         |
| P      | +05:45                          | Timezone offset with colon              |
| Z      | 20700                           | Timezone offset in seconds              |
| c      | 2082-02-01T14:30:00+05:45       | ISO 8601 datetime                       |
| r      | Sun, 01 Bai 2082 14:30:00 +0530 | RFC 2822 datetime                       |
| U      | 1675289400                      | Unix timestamp (Using Ad Date and Time) |

**Example:**

```php
    use RohanAdhikari\NepaliDate\NepaliDate;
    // Get the current Nepali date and time
    $date = NepaliDate::now();

    // Using a predefined format (24-hour datetime)
    echo $date->format(NepaliDate::FORMAT_DATETIME_24);
    // Example output: 2082-06-31 21:14

    // Using a custom format string
    echo $date->format('Y-m-d H:i');
    // Example output: 2082-06-31 21:14

    // Using full month name + weekday
    echo $date->format('l, F j, Y');
    // Example output: Friday, Ashwin 31, 2082

    // Using ISO 8601 format
    echo $date->format('c');
    // Example output: 2082-06-31T21:14:14+05:45

    // Using RFC 2822 format
    echo $date->format('r');
    // Example output: Fri, 31 Asw 2082 21:14:14 +0545
```

---

## 🌐 Locale

Available locales: `en` and `np`.

**Example:**

```php
    use RohanAdhikari\NepaliDate\NepaliDate;

    $date = NepaliDate::now();
    $date->setLocale(NepaliDate::NEPALI); //Using defined constant
    //or
    $date->locale('np');
    //or
    $date->locale = 'np'; //Not supported for ImmmutableNepaliDate

    echo $date->format(NepaliDate::FORMAT_DATETIME_24);
    //Example Output: २०८२-०६-३१ २१:३४
```

> [!Note]
> You can also set the global default locale as:-
>
> ```php
> NepaliDate::defaultLocale(NepaliDate::NEPALI);
> ```
>
> Any new instance of `NepaliDate` will now use this locale by default.

---

## Parse

---

## ➕ Unit Operations (Add/Subtract)

// TODO: document addDays, addMonths, subYears, etc.

---

## Dates Difference

// TODO: document addDays, addMonths, subYears, etc.

---

## 🔍 Getters

// TODO: document getYear, getMonth, getDay, etc.

---

## ⚙️ Setters

// TODO: document setYear, setTime, setUnit, etc.

---

## Shifting

The `NepaliDate` provides methods to shift dates to their corresponding values based on different contexts like timezone or week.

### TimeZone

//TODO:

### Week

```php
use RohanAdhikari\NepaliDate\NepaliDate;

 $nepaliDate = NepaliDate::parse('2082-07-02');
    // shif to previous monday
    $nepaliDate->shiftToNearWeek(NepaliWeekDay::Monday, false);
    echo $nepaliDate->format(NepaliDate::FORMAT_DATE_SLASH_YMD);
    // shif to next monday
    $nepaliDate->shiftToNearWeek(NepaliDate::MONDAY);
    //or
    $nepaliDate->shiftToNearWeek(NepaliWeekDay::Monday);
    echo $nepaliDate->format(NepaliDate::FORMAT_DATE_SLASH_YMD);

```

---

## 📏 Boundaries Methods

Boundary methods are used to snap a date/time to the start or end of a defined unit. This is extremely useful for:

- Rounding dates to the beginning or end of a day, week, month, or year.

- Performing date calculations for calendars.

- Filtering datasets by time ranges.

### Available Methods

| Method                  | Description                                                                                |
| ----------------------- | ------------------------------------------------------------------------------------------ |
| startOfDay()            | Sets the time to the very beginning of the day (00:00:00).                                 |
| endOfDay()              | Sets the time to the very end of the day (23:59:59).                                       |
| startOfWeek($weekStart) | Moves the date to the first day of the week (Sunday by default, customizable).             |
| endOfWeek($weekEnd)     | Moves the date to the last day of the week (Saturday by default, customizable).            |
| startOfMonth()          | Moves the date to the first day of the month at 00:00:00.                                  |
| endOfMonth()            | Moves the date to the last day of the month at 23:59:59.                                   |
| startOfQuarter()        | Moves the date to the first day of the current quarter at 00:00:00.                        |
| endOfQuarter()          | Moves the date to the last day of the current quarter at 23:59:59.                         |
| startOfYear()           | Moves the date to the first day of the year at 00:00:00.                                   |
| endOfYear()             | Moves the date to the last day of the year at 23:59:59.                                    |
| startOfDecade()         | Moves the date to the first year of the decade at 00:00:00.                                |
| endOfDecade()           | Moves the date to the last year of the decade at 23:59:59.                                 |
| startOfCentury()        | Moves the date to the first year of the century at 00:00:00.                               |
| endOfCentury()          | Moves the date to the last year of the century at 23:59:59.                                |
| startOfMillennium()     | Moves the date to the first year of the millennium at 00:00:00.                            |
| endOfMillennium()       | Moves the date to the last year of the millennium at 23:59:59.                             |
| startOfHour()           | Sets minutes and seconds to 00:00 of the current hour.                                     |
| endOfHour()             | Sets minutes and seconds to 59:59 of the current hour.                                     |
| startOfMinute()         | Sets seconds to 00 of the current minute.                                                  |
| endOfMinute()           | Sets seconds to 59 of the current minute.                                                  |
| startOf(unit)           | Generic method to snap the date to the start of a specified unit (day, month, year, etc.). |
| endOf(unit)             | Generic method to snap the date to the end of a specified unit (day, month, year, etc.).   |

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

$nepaliDate = NepaliDateImmutable::now();
// end of century
echo $nepaliDate->endOfCentury(); // auto convert to string using FORMAT_DATETIME_24_FULL
// Example Output: 2100-12-31 23:59:59

// start of decade
echo $nepaliDate->startOfDecade()->format(NepaliDate::FORMAT_DATE_SLASH_YMD);
// Example Output: 2080/01/01

//start of quarter
echo $nepaliDate->startOf(NepaliUnit::Quarter)->format(NepaliDate::FORMAT_DATETIME_24_FULL);
    // Example Output: 2082-07-01 00:00:00

//end of week
echo $nepaliDate->endOf(NepaliUnit::Week)->format(NepaliDate::FORMAT_DATETIME_24_FULL);
// Example Output: 2082-07-01 23:59:59
```

---

## 🔎 Comparison

The `NepaliDate` class provides a comprehensive set of **comparison and state-checking methods**.  
These methods allow you to compare dates, check if a date falls within a range, or determine its temporal state (past, future, today, etc.).  
All methods accept either another `NepaliDateInterface` instance or a date string that can be parsed into a Nepali date.

| Method                                   | Alias / Shortcut                           | Description                                                                     |
| ---------------------------------------- | ------------------------------------------ | ------------------------------------------------------------------------------- |
| `equalTo($date)`                         | `eq($date)`                                | Returns `true` if the current date is equal to the given date.                  |
| `notEqualTo($date)`                      | `ne($date)`                                | Returns `true` if the current date is not equal to the given date.              |
| `greaterThan($date)`                     | `gt($date)`, `isAfter($date)`              | Returns `true` if the current date is after the given date.                     |
| `greaterThanOrEqualTo($date)`            | `gte($date)`                               | Returns `true` if the current date is after or equal to the given date.         |
| `lessThan($date)`                        | `lt($date)`, `isBefore($date)`             | Returns `true` if the current date is before the given date.                    |
| `lessThanOrEqualTo($date)`               | `lte($date)`                               | Returns `true` if the current date is before or equal to the given date.        |
| `between($date1, $date2, $equal = true)` | `isBetween($date1, $date2, $equal = true)` | Returns `true` if the current date is between two dates (inclusive by default). |
| `betweenIncluded($date1, $date2)`        | —                                          | Returns `true` if the current date is between two dates, inclusive.             |
| `betweenExcluded($date1, $date2)`        | —                                          | Returns `true` if the current date is between two dates, exclusive.             |
| `isWeekday()`                            | —                                          | Returns `true` if the current date is a weekday (not Saturday).                 |
| `isWeekend()`                            | —                                          | Returns `true` if the current date is a weekend (Saturday).                     |
| `isYesterday()`                          | —                                          | Returns `true` if the current date represents yesterday.                        |
| `isToday()`                              | —                                          | Returns `true` if the current date represents today.                            |
| `isTomorrow()`                           | —                                          | Returns `true` if the current date represents tomorrow.                         |
| `isFuture()`                             | —                                          | Returns `true` if the current date is in the future.                            |
| `isPast()`                               | —                                          | Returns `true` if the current date is in the past.                              |
| `isNowOrFuture()`                        | —                                          | Returns `true` if the current date is now or in the future.                     |
| `isNowOrPast()`                          | —                                          | Returns `true` if the current date is now or in the past.                       |

**Example:**

```php
use RohanAdhikari\NepaliDate\NepaliDate;

    //Today Date: 2082-07-01
    $nepaliDate = NepaliDate::parse('2082-07-02'); //WeekDay: Sunday

    var_dump($nepaliDate->eq('2082-07-02'));
    // Output: bool(true)

    var_dump($nepaliDate->gt('2082-07-02'));
    // Output: bool(false)

    var_dump($nepaliDate->gt(NepaliDate::now()));
    // Output: bool(true)

    var_dump($nepaliDate->lt(NepaliDate::now()));
    // Output: bool(false)

    var_dump($nepaliDate->between('2082-07-01', '2082-07-03'));
    // Output: bool(true)

    var_dump($nepaliDate->betweenExcluded('2082-07-01', '2082-07-02'));
    // Output: bool(false)

    var_dump($nepaliDate->betweenIncluded('2082-07-01', '2082-07-02'));
    // Output: bool(true)

    var_dump($nepaliDate->isPast());
    // Output: bool(false)

    // Check if the date is tomorrow
    var_dump($nepaliDate->isTomorrow());
    // Output: bool(true)

    // Check if the date is weekday
    var_dump($nepaliDate->isWeekday());
    // Output: bool(true)

    // Check if the date is weekend
    var_dump($nepaliDate->subDays(1)->isWeekend());
    // Output: bool(true)
```

---

## Additional

<!-- ## Usage in Laravel Example

For detailed instructions on using **NepaliDate** in a Laravel application, see the [Laravel Integration Guide](./docs/LARAVEL.md). -->

### 🌐 Locale Customization

You can customize locale data for months, weekdays, numbers, and more.  
For detailed instructions, see the [LocaleCustomize](./docs/LOCALECUSTOMIZE.md) documentation.

---

### ⚡ Custom Functions / Macros

You can also add your own functions or macros to extend `NepaliDateTime` functionality.  
For detailed instructions, see the [Macro](./docs/MACRO.md) documentation.

---

### NepaliNumbers

You can also use the `NepaliNumbers` class to work with Nepali numerals.
For detailed information, see the [NepaliNumbers](./docs/NEPALINUMBERS.md) documentation.

<!-- ### Calendar

You can use the `Calendar` class to work with total days in a year and to get week information.
For detailed information, see the [Calendar](./docs/CALENDER.md) documentation. -->
